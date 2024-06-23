<?php

namespace App\Http\Controllers\Aktivitas;

use File;
use Image;

use Spatie\Tags\Tag;
use Jenssegers\Date\Date;
use App\Models\Blog\Author;
use Illuminate\Support\Str;
use App\Models\Blog\Article;
use Illuminate\Http\Request;

use App\Helpers\StringHelper;

use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Aktivitas\Activities;
use App\Models\Aktivitas\Department;
use Illuminate\Support\Facades\Session;
use App\Models\Aktivitas\ActivityStatus;
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
    $this->active = 'Aktivitas Pegawai';
    $this->route = 'aktivitas';
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

    // pilih department berdasarkan posisi saat login
    $department = DepartmentPosition::with('department')->where('position_id', $pegawai->position_id)->get();

    $active = $this->active;
    $route = $this->route;

    if ($department && count($department) > 1) {
      return view('kepegawaian.read-only.aktivitas_index', compact('department', 'active', 'route'));
    } else {
      $department = DepartmentPosition::with('department')->where('position_id', $pegawai->position_id)->first();

      return redirect()->route($this->route . '.create', ['status' => 1, 'department' => $department->department->name]);
    }
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create(Request $request)
  {

    // pilih aktivitas berdasarkan nama department
    $department = $request->department;
    $status = ActivityStatus::all();
    $aktif = $request->status;

    $aktivitas = Activities::with('department')
      ->whereHas('department', function ($query) use ($request) {
        $query->where(['name' => $request->department, 'status_id' => $request->status]);
      })
      ->get();

    $route = $this->route;
    $active = $this->active;

    return view('kepegawaian.read-only.aktivitas_show', compact('aktivitas', 'department', 'route', 'active', 'status', 'aktif'));
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
      'name.required' => 'Mohon isikan nama aktivitas',
      'image.file' => 'Pastikan image adalah berkas yang valid',
      'image.max' => 'Ukuran image yang boleh diunggah maksimum 100kb',
      'image.mimes' => 'Pastikan image yang diunggah berekstensi .jpg, .jpeg, .png, atau .webp',
      'image.dimensions' => 'Pastikan image yang diunggah beresolusi minimum 400x300',
      'startDate' => 'Pastikan format yang dimasukan adalah tanggal',
      'finishDate' => 'Pastikan format yang dimasukan adalah tanggal',

    ];

    $this->validate($request, [
      'name' => 'required',
      'image' => 'file|max:100|mimes:jpg,jpeg,png,webp',
      'startDate' => 'nullable|date',
      'finishDate' => 'nullable|date',
    ], $messages);

    $activity = Activities::where([
      'name' => $request->name,
      'start_date' => $request->startDate,
    ])->get();

    $pegawai_id = $request->user()->pegawai->id;
    $department = Department::where('name', $request->department)->first();

    if ($department && $activity && count($activity) < 1) {
      $item = new Activities();
      $item->name = $request->name;
      $item->desc = $request->desc;
      $item->start_date = Date::now();
      $item->status_id = 1;
      $item->department_id = $department->id;
      $item->employe_id = $pegawai_id;
      $item->save();
      $item->fresh();

      $item->image = isset($image) ? $image : null;
      $item->save();

      Session::flash('success', 'Data ' . strtolower($this->active) . ' ' . $item->name . ' berhasil ditambahkan');
    } else Session::flash('danger', 'Data ' . $request->name . ' sudah pernah ditambahkan');

    return redirect()->route($this->route . '.create', ['status' => 1, 'department' => $department->name]);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show(Request $request)
  {
    $data = Activities::find($request->id);

    return $data;
    if ($data) {
      $active = $this->active;
      $route = $this->route;

      return view($route . '_detail', compact('data', 'active', 'route'));
    } else return redirect()->route($this->route . '.index');
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit(Request $request)
  {
    $data = $request->id ? Activities::find($request->id) : null;

    if ($data) {
      $active = $this->active;
      $route = $this->route;

      return view('kepegawaian.read-only.aktivitas_edit', compact('data', 'active', 'route'));
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
      'editName.required' => 'Mohon isikan nama aktivitas',
    ];

    $this->validate($request, [
      'editName' => 'required',
    ], $messages);

    $date_now = Carbon::now()->format('Y-m-d');
    $item = Activities::find($request->id);
    $activity = Activities::with('department')->where('id', $request->id)->first();

    $aktivitas = Activities::where([
      'name' => $request->editName,
      'desc' => $request->editDesc,
      'start_date' => $date_now,
      'department_id' => $request->department_id
    ])->where('id', '!=', $request->id);

    if ($item && $aktivitas->count() < 1) {
      $name             = $item->name;
      $item->name       = $request->editName;
      $item->desc       = $request->editDesc;
      $item->start_date = Date::now();
      $item->save();
      Session::flash('success', 'Data ' . strtolower($this->active) . ' ' . $name . ' berhasil diubah');
    } else Session::flash('danger', 'Perubahan data gagal disimpan karena sudah ada yang sama');

    return redirect()->route($this->route . '.create', ['status' => $item->status_id, 'department' => $activity->department->name]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $item = Activities::find($id);
    $status_id = $item->status_id;
    $department = $item->department->name;

    if ($item) {

      $name = $item->name;
      $item->delete();

      Session::flash('success', 'Data ' . strtolower($this->active) . ' ' . $name . ' berhasil dihapus');
    } else Session::flash('danger', 'Data gagal dihapus');

    return redirect()->route($this->route . '.create', ['status' => $status_id, 'department' => $department]);
  }

  /**
   * update status ongoing the activity.
   *
   * @return \Illuminate\Http\Response
   */
  public function ongoing(Request $request)
  {
    $item = Activities::where('id', $request->id)->first();

    if ($item) {
      $name = $item->name;
      $item->status_id = 2;
      $item->save();

      Session::flash('update', 'Data ' . strtolower($this->active) . ' ' . $name . ' diubah statusnya');
    } else Session::flash('danger', 'Perubahan status data gagal ');

    return redirect()->route($this->route . '.create', ['status' => $item->status_id, 'department' => $item->department->name]);
  }

  /**
   * Show the form for editing before finish.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function editFinish(Request $request)
  {
    $data = $request->id ? Activities::find($request->id) : null;

    if ($data) {
      $active = $this->active;
      $route = $this->route;

      return view('kepegawaian.read-only.aktivitas_edit_finish', compact('data', 'active', 'route'));
    } else return redirect()->route($this->route . '.index');
  }

  /**
   * finish the activity.
   *
   * @return \Illuminate\Http\Response
   */
  public function finish(Request $request)
  {
    // return Activities::where('id', $request->id)->first();
    $messages = [
      'editImage.file' => 'Pastikan image adalah berkas yang valid',
      'editImage.max' => 'Ukuran image yang boleh diunggah maksimum 100kb',
      'editImage.mimes' => 'Pastikan image yang diunggah berekstensi .jpg, .jpeg, .png, atau .webp',
    ];

    $this->validate($request, [
      'editImage' => 'file|max:100|mimes:jpg,jpeg,png,webp',
    ], $messages);

    $item = Activities::where('id', $request->id)->first();

    if ($item) {

      // edit gambar
      if ($request->file('editImage') && $request->file('editImage')->isValid()) {
        // Delete service image from public
        if (File::exists($item->imagePath)) {
          File::delete($item->imagePath);
        }
        // Move service icon to public
        $file = $request->file('editImage');
        $image = $item->id . '_' . time() . '_image.' . $file->getClientOriginalExtension();
        $file->move('img/aktivitas/', $image);
      }

      $name = $item->name;
      $item->image = isset($image) ? $image : $item->image;
      $item->status_id = 3;
      $item->end_date = Date::now();
      $item->save();

      Session::flash('update', 'Data ' . strtolower($this->active) . ' ' . $name . ' diubah statusnya');
    } else Session::flash('danger', 'Perubahan status data gagal ');

    return redirect()->route($this->route . '.create', ['status' => $item->status_id, 'department' => $item->department->name]);
  }
}
