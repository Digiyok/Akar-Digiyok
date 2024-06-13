<?php

namespace App\Http\Controllers\Aktivitas;

use File;
use Image;

use Session;
use Spatie\Tags\Tag;
use Jenssegers\Date\Date;
use App\Models\Blog\Author;
use Illuminate\Support\Str;
use App\Models\Blog\Article;

use Illuminate\Http\Request;

use App\Helpers\StringHelper;
use App\Http\Controllers\Controller;
use App\Models\Aktivitas\Department;
use App\Models\Aktivitas\DepartmentPosition;

class AktivitasController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->active = 'Artikel';
    $this->route = 'admin.news-activities.article';
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $pegawai = $request->user()->pegawai;
    $role = $request->user()->role->name;
    $department = DepartmentPosition::with('position')->get();

    return $pegawai;
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $authors = Author::orderBy('name')->get();
    $categories = ArticleCategory::orderBy('name')->get();

    $active = $this->active;
    $route = $this->route;

    return view($route . '-create', compact('active', 'route', 'authors', 'categories'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $messages = [
      'author.required' => 'Mohon pilih salah satu penulis',
      'title.required' => 'Mohon tuliskan judul ' . strtolower($this->active),
      'title.unique' => 'Judul ' . strtolower($this->active) . ' ini sudah ada',
      'text.required' => 'Mohon tuliskan isi ' . strtolower($this->active),
      'thumbnail.required' => 'Mohon tentukan gambar ' . strtolower($this->active),
      'thumbnail.file' => 'Pastikan gambar adalah berkas yang valid',
      'thumbnail.max' => 'Ukuran gambar yang boleh diunggah maksimum 256 KB',
      'thumbnail.mimes' => 'Pastikan gambar yang diunggah berekstensi .jpg, .jpeg, .png, atau .webp',
      'thumbnail.dimensions' => 'Pastikan gambar yang diunggah beresolusi minimum 540x360 px',
    ];

    $this->validate($request, [
      'author' => 'required',
      'title' => 'required|unique:App\Models\Blog\Article,title',
      'text' => 'required',
      'thumbnail' => 'required|file|max:256|mimes:jpg,jpeg,png,webp|dimensions:min_width=540,min_height=360',
    ], $messages);

    $article = Article::where([
      'title' => $request->title
    ]);

    if ($article->count() < 1) {
      $author = Author::where('id', $request->author)->first();
      if ($author) {
        $item = new Article();
        $item->author_id = $request->author;
        $item->title = $request->title;
        $item->title_slug = Str::slug($request->title);
        $item->text = $request->text;
        $item->keywords = $request->keywords;
        $item->thumbnail = '#';
        if ($request->unlisted == 'on') {
          $item->is_listed = 0;
        }
        if ($request->publish == 'on') {
          $item->is_draft = 0;
          $item->published_at = Date::now('Asia/Jakarta');
        } else {
          $item->is_draft = 1;
        }
        $item->save();
        $item->fresh();

        if ($request->keywords) {
          $item->attachTags(explode(',', $request->keywords), 'newsTag');
        }

        if ($request->file('thumbnail') && $request->file('thumbnail')->isValid()) {
          // Move article's thumbnail to public
          $file = $request->file('thumbnail');
          $thumbnail = $item->id . '_' . time() . '_thumbnail.' . $file->getClientOriginalExtension();
          // Small Thumbnail
          $path = public_path('img/article/');
          if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
          }
          $smallThumbnail = Image::make($file->getRealPath());
          $smallThumbnail->encode('webp', 90)->resize(540, 360, function ($constraint) {
            $constraint->aspectRatio();
          })->save('img/article/' . $thumbnail . '.webp');
          // Original
          $file->move('img/article/', $thumbnail);
        }

        $item->thumbnail = isset($thumbnail) ? $thumbnail : null;
        $item->save();
        $item->fresh();

        if (isset($request->categories) && count($request->categories) > 0) {
          $item->categories()->attach($request->categories);
        }

        Session::flash('success', 'Data ' . $item->title . ' berhasil ditambahkan');
      } else Session::flash('danger', 'Mohon pilih salah satu penuls yang valid');
    } else {
      $founder = $founder->first();
      Session::flash('danger', 'Data ' . $founder->employee->nameWithTitle . ' sudah pernah ditambahkan');
    }

    return redirect()->route($this->route . '.index');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $data = Article::find($id);
    if ($data) {
      $active = $this->active;
      $route = $this->route;

      return view($route . '-show', compact('data', 'active', 'route'));
    } else return redirect()->route($this->route . '.index');
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $data = Article::find($id);
    if ($data) {
      $authors = Author::orderBy('name')->get();
      $categories = ArticleCategory::orderBy('name')->get();

      $active = $this->active;
      $route = $this->route;

      return view($route . '-edit', compact('data', 'active', 'route', 'authors', 'categories'));
    } else return redirect()->route($this->route . '.index');
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request)
  {
    $messages = [
      'editAuthor.required' => 'Mohon pilih salah satu penulis',
      'editTitle.required' => 'Mohon tuliskan judul ' . strtolower($this->active),
      'editText.required' => 'Mohon tuliskan isi ' . strtolower($this->active),
      'editThumbnail.file' => 'Pastikan gambar adalah berkas yang valid',
      'editThumbnail.max' => 'Ukuran gambar yang boleh diunggah maksimum 256 KB',
      'editThumbnail.mimes' => 'Pastikan gambar yang diunggah berekstensi .jpg, .jpeg, .png, atau .webp',
      'editThumbnail.dimensions' => 'Pastikan gambar yang diunggah beresolusi minimum 540x360 px',
    ];

    $this->validate($request, [
      'editAuthor' => 'required',
      'editTitle' => 'required',
      'editText' => 'required',
      'editThumbnail' => 'file|max:256|mimes:jpg,jpeg,png,webp|dimensions:min_width=540,min_height=360',
    ], $messages);

    $item = Article::find($request->id);

    $article = Article::where([
      'title' => $request->editTitle
    ])->where('id', '!=', $request->id);

    if ($item && $article->count() < 1) {
      $author = Author::where('id', $request->editAuthor)->first();
      if ($author) {
        if ($request->file('editThumbnail') && $request->file('editThumbnail')->isValid()) {
          // Delete article's thumbnail from public
          if (File::exists($item->thumbnailSmPath)) File::delete($item->thumbnailSmPath);
          if (File::exists($item->thumbnailPath)) File::delete($item->thumbnailPath);

          // Move article's thumbnail to public
          $file = $request->file('editThumbnail');
          $thumbnail = $item->id . '_' . time() . '_thumbnail.' . $file->getClientOriginalExtension();
          // Small Thumbnail
          $path = public_path('img/article/');
          if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
          }
          $smallThumbnail = Image::make($file->getRealPath());
          $smallThumbnail->encode('webp', 90)->resize(540, 360, function ($constraint) {
            $constraint->aspectRatio();
          })->save('img/article/' . $thumbnail . '.webp');
          // Original
          $file->move('img/article/', $thumbnail);
        }

        $old = $item->title;

        $item->author_id = $request->editAuthor;
        $item->title = $request->editTitle;
        $item->title_slug = Str::slug($request->editTitle);
        $item->text = $request->editText;
        $item->keywords = $request->editKeywords;
        if ($request->editKeywords) {
          $item->syncTagsWithType(explode(',', $request->editKeywords), 'newsTag');
        } else {
          $item->detachTags($item->tagsWithType('newsTag'));
        }
        $item->thumbnail = isset($thumbnail) ? $thumbnail : $item->thumbnail;
        $reading_time = StringHelper::estimateReadingTime($request->editText);
        $item->reading_time = $reading_time['minutes'] < 1 ? $reading_time['seconds'] . ' detik' : $reading_time['minutes'] . ' menit';
        $item->is_listed = isset($request->editUnlisted) && ($request->editUnlisted == 'on') ? 0 : 1;
        if ($item->is_draft == 0 && $item->published_at) {
          $item->is_active = $request->editActive == 'on' ? 1 : 0;
        }
        $item->save();
        $item->fresh();

        if (isset($request->editCategories) && count($request->editCategories) > 0) {
          if ($item->categories()->count() > 0)
            $item->categories()->sync($request->editCategories);
          else
            $item->categories()->attach($request->editCategories);
        } else {
          $item->categories()->detach();
        }

        Session::flash('success', 'Data ' . $old . ' berhasil diubah' . ($old != $item->title ? ' menjadi ' . $item->title : ''));

        return redirect()->route($this->route . '.edit', ['id' => $item->id]);
      } else Session::flash('danger', 'Mohon pilih salah satu penulis yang valid');
    } else Session::flash('danger', 'Perubahan data gagal disimpan');

    return redirect()->route($this->route . '.index');
  }

  /**
   * Publish the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function publish(Request $request)
  {
    $item = Article::where('id', $request->id)->where(function ($q) {
      $q->draft()->orWhereNull('published_at');
    })->first();

    if ($item) {
      $item->is_draft = 0;
      $item->published_at = Date::now('Asia/Jakarta');
      $item->save();

      Session::flash('success', 'Artikel ' . $item->title . ' berhasil dipublikasi');

      if ($request->ref) {
        return redirect()->route($this->route . '.' . $request->ref, ['id' => $item->id]);
      }
    } else Session::flash('danger', 'Perubahan data gagal dipublikasi');

    return redirect()->route($this->route . '.index');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $item = Article::where('id', $id)->where(function ($q) {
      $q->where(function ($q) {
        $q->published()->inactive();
      })->orWhere(function ($q) {
        $q->draft();
      });
    })->first();
    if ($item) {
      // Delete article's thumbnail from public
      if (File::exists($item->thumbnailSmPath)) File::delete($item->thumbnailSmPath);
      if (File::exists($item->thumbnailPath)) File::delete($item->thumbnailPath);

      if ($item->categories()->count() > 0) $item->categories()->detach();

      $item->detachTags($item->tagsWithType('newsTag'));

      $name = $item->title;
      $item->delete();

      Session::flash('success', 'Data ' . $name . ' berhasil dihapus');
    } else Session::flash('danger', 'Data gagal dihapus');

    return redirect()->route($this->route . '.index');
  }
}
