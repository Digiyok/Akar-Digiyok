@extends('template.main.master')

@section('title')
  Aktifitas Pegawai
@endsection

@section('headmeta')
  <!-- Bootstrap DatePicker -->
  <link href="{{ asset('vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
  <!-- DataTables -->
  <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
  <!-- Select2 -->
  <link href="{{ asset('vendor/select2/dist/css/select2.min.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/select2/dist/css/select2-bootstrap4.min.css') }}" rel="stylesheet">

  <meta name="csrf-token" content="{{ Session::token() }}" />
@endsection

@section('sidebar')
  @include('template.sidebar.kepegawaian.' . Auth::user()->role->name)
@endsection

@section('content')
  <div class="d-sm-flex align-items-center justify-content-between mb-2">
    <h1 class="h3 mb-0 text-gray-800">Aktivitas Pegawai Department {{ $department }}</h1>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="./">Beranda</a></li>
      <li class="breadcrumb-item"><a href="{{ route('pelatihan.saya.index') }}">Aktifitas Pegawai</a></li>
      {{-- <li class="breadcrumb-item active" aria-current="page">Materi</li> --}}
    </ol>
  </div>

  <div class="row mb-4">
    <div class="col-12">
      <div class="card shadow">
        <div class="card-body">
          <ul class="nav nav-pills">
            @foreach ($status as $s)
              @php
                $navLink = route($route . '.create', ['status' => $s->id, 'department' => $department]);
              @endphp
              <li class="nav-item">
                <a class="nav-link {{ $s->id == $aktif ? 'active' : 'text-brand-green' }}"
                  href="{{ $s->id == $aktif ? 'javascript:void(0)' : $navLink }}">{{ $s->status }}</a>
              </li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
  </div>

  <div class="row mb-4">
    <div class="col-12">
      <div class="card">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-brand-green">Aktivitas Pegawai Department {{ $department }}</h6>
          @if ($aktif == 1)
            <button class="m-0 float-right btn btn-brand-green-dark btn-sm" data-toggle="modal" data-target="#add-form"
              type="button">Tambah <i class="fas fa-plus-circle ml-1"></i></button>
          @endif
        </div>
        <div class="card-body p-3">
          @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <strong>Sukses!</strong> {{ Session::get('success') }}
              <button class="close" data-dismiss="alert" type="button" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          @endif
          @if (Session::has('danger'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <strong>Gagal!</strong> {{ Session::get('danger') }}
              <button class="close" data-dismiss="alert" type="button" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          @endif
          @if (Session::has('update'))
            <div class="alert alert-primary alert-dismissible fade show" role="alert">
              <strong>Sukses!</strong> {{ Session::get('update') }}
              <button class="close" data-dismiss="alert" type="button" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          @endif
          @if (count($aktivitas) > 0)
            <div class="table-responsive">
              <table class="table align-items-center table-flush" id="dataTable">
                <thead class="thead-light">
                  <tr>
                    <th style="width: 15px">#</th>
                    <th>Nama Aktifitas</th>
                    <th>Deskripsi</th>
                    @if ($aktif == 3)
                      <th>Dokumen</th>
                    @endif
                    <th>Tgl Mulai</th>
                    @if ($aktif == 3)
                      <th>Tgl Selesai</th>
                    @endif
                    <th>Status</th>
                    <th>Pegawai</th>
                    @if ($aktif == 1 || $aktif == 2)
                      <th>Aksi</th>
                    @endif
                  </tr>
                </thead>
                <tbody>
                  @php $no = 1; @endphp
                  @foreach ($aktivitas as $a)
                    <tr>
                      <td>{{ $no++ }}</td>
                      <td>{{ $a->name }}</td>
                      <td>{{ $a->desc }}</td>
                      @if ($aktif == 3)
                        <td>{!! $a->avatar !!}</td>
                      @endif
                      <td>{{ $a->formatted_start_date }}</td>
                      @if ($aktif == 3)
                        <td>{{ $a->formatted_end_date }}</td>
                      @endif
                      <td>
                        @if ($aktif == 1)
                          <span class="badge badge-pill badge-danger">Belum Selesai</span>
                        @elseif($aktif == 2)
                          <span class="badge badge-pill badge-primary">Sedang Dikerjakan</span>
                        @elseif($aktif == 3)
                          <span class="badge badge-pill badge-success">Selesai</span>
                        @endif
                      </td>
                      <td>{{ optional($a->pegawai)->nickname }}</td>

                      {{-- aksi --}}
                      @if ($aktif == 1 || $aktif == 2)
                        <td>
                          @if ($aktif == 1)
                            <a class="btn btn-sm btn-warning " data-toggle="modal" data-target="#edit-form"
                              data-toggle="modal" href="#"
                              onclick="editModal('{{ route('aktivitas.edit') }}','{{ $a->id }}')"><i
                                class="fas fa-pen"></i></a>

                            <a class="btn btn-sm btn-primary " data-target="#ongoing-confirm" data-toggle="modal"
                              href="#"
                              onclick="ongoingModal('{{ $active }}', '{!! addslashes(htmlspecialchars($a->name)) !!}', '{{ route('aktivitas.ongoing', ['id' => $a->id]) }}')"><i
                                class="fas fa-file-signature"></i></a>

                            <a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete-confirm"
                              href="#"
                              onclick="deleteModal('{{ $active }}', '{!! addslashes(htmlspecialchars($a->name)) !!}', '{{ route($route . '.destroy', ['id' => $a->id]) }}')"><i
                                class="fas fa-trash"></i></a>
                          @elseif($aktif == 2)
                            <a class="btn btn-sm btn-warning " data-toggle="modal" data-target="#edit-form"
                              data-toggle="modal" href="#"
                              onclick="editModal('{{ route('aktivitas.edit') }}','{{ $a->id }}')"><i
                                class="fas fa-pen"></i></a>

                            {{-- <a class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#show-modal"
                              data-toggle="modal" href="#" lass="btn btn-sm btn-success "
                              onclick="showModal('{{ route('aktivitas.show') }}','{{ $a->id }}')"><i
                                class="fas fa-eye"></i></a> --}}

                            <a class="btn btn-sm btn-success " data-toggle="modal" data-target="#finish-form"
                              data-toggle="modal" href="#"
                              onclick="finishModal('{{ route('aktivitas.edit-finish') }}','{{ $a->id }}')"><i
                                class="fas fa-check"></i></a>

                            {{-- <a href="{{ route('aktivitas.show', ['id' => $a->id]) }}">tes</a> --}}

                            <a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete-confirm"
                              href="#"
                              onclick="deleteModal('{{ $active }}', '{!! addslashes(htmlspecialchars($a->name)) !!}', '{{ route($route . '.destroy', ['id' => $a->id]) }}')"><i
                                class="fas fa-trash"></i></a>
                          @endif
                        </td>
                      @endif

                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @else
            <div class="text-center mx-3 mt-4 mb-5">
              <h3>Mohon Maaf,</h3>
              <h6 class="font-weight-light mb-3">Tidak ada data Aktivitas Pegawai yang ditemukan</h6>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>

  <div class="row mb-4">
    <div class="col-12">
      <div class="card shadow">
        <div class="card-body d-flex justify-content-end">
          <a class="btn btn-secondary" href="{{ route('aktivitas.index') }}">Lihat Department Lain</a>
        </div>
      </div>
    </div>
  </div>

  {{-- modal form --}}
  <div class="modal fade" id="add-form" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
    tabindex="-1" style="display: none;">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header bg-brand-green border-0">
          <h5 class="modal-title text-white">Aktivitas Pegawai Department {{ $department }}</h5>
          <button class="close" data-dismiss="modal" type="button" aria-label="Close">
            <span aria-hidden="true">x</span>
          </button>
        </div>

        <div class="modal-body p-4">
          <form id="aktifitas-form" action="{{ route('aktivitas.store') }}" method="post"
            enctype="multipart/form-data" accept-charset="utf-8">
            {{ csrf_field() }}

            <input id="department" name="department" type="hidden" value="{{ $department }}" required="required">

            <div class="row mb-2">
              <div class="col-12">
                <div class="form-group">
                  <div class="row">
                    <div class="col-12">
                      <label class="form-control-label" for="normal-input">Nama Aktivitas<span
                          class="text-danger">*</span></label>
                    </div>
                    <div class="col-12">
                      <input class="form-control" id="name" name="name" value="{{ old('name') }}"
                        maxlength="255" required="required">
                      @error('name')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="row mb-2">
              <div class="col-12">
                <div class="form-group">
                  <div class="row">
                    <div class="col-12">
                      <label class="form-control-label" for="normal-input">Deskripsi</label>
                    </div>
                    <div class="col-12">
                      <textarea class="form-control" id="desc" name="desc" maxlength="255" rows="3">{{ old('desc') }}</textarea>
                      @error('desc')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                </div>
              </div>
            </div>

            {{-- <div class="row mb-2">
              <div class="col-lg-10 col-md-12">
                <div class="form-group">
                  <div class="row mb-3">
                    <div class="col-lg-3 col-md-4 col-12">
                      <label class="form-control-label" for="normal-input">Gambar</label>
                    </div>
                    <div class="col-lg-7 col-md-8 col-12">
                      @php
                        $inputImageName = 'image';
                      @endphp
                      <img class="img-thumbnail photo-preview" id="preview{{ ucwords($inputImageName) }}"
                        src="{{ asset('img/bio_icon/default.png') }}">
                      <input class="file image-input d-none" name="{{ $inputImageName }}" type="file"
                        accept="image/jpg,image/jpeg,image/png,image/webp">
                      <div class="input-group mt-3">
                        <input class="form-control form-control-sm @error($inputImageName) is-invalid @enderror"
                          id="file{{ ucwords($inputImageName) }}" type="text" disabled
                          placeholder="Unggah photo...">
                        <div class="input-group-append">
                          <button class="browse btn btn-sm btn-primary" type="button">Pilih</button>
                        </div>
                      </div>
                      <small class="form-text text-muted">Ekstensi .jpg, .jpeg, .png, .webp. Maks 200
                        KB.</small>
                      @error($inputImageName)
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                </div>
              </div>
            </div> --}}

            <div class="row mt-3">
              <div class="col-6 text-left">
                <button class="btn btn-light" data-dismiss="modal" type="button">Kembali</button>
              </div>
              <div class="col-6 text-right">
                <input class="btn btn-brand-green-dark" type="submit" value="Tambah">
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  {{-- modal form end --}}

  {{-- edit modal --}}
  <div class="modal fade" id="edit-form" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
    tabindex="-1" style="display: none;">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header bg-brand-green border-0">
          <h5 class="modal-title text-white">Ubah</h5>
          <button class="close" data-dismiss="modal" type="button" aria-label="Close">
            <span aria-hidden="true">x</span>
          </button>
        </div>

        <div class="modal-load p-4">
          <div class="row">
            <div class="col-12">
              <div class="text-center my-5">
                <i class="fa fa-spin fa-circle-notch fa-lg text-brand-green"></i>
                <h5 class="font-weight-light mb-3">Memuat...</h5>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-body p-4" style="display: none;">
        </div>
      </div>
    </div>
  </div>
  {{-- edit modal end --}}

  {{-- edit finish modal --}}
  <div class="modal fade" id="finish-form" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
    tabindex="-1" style="display: none;">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header bg-brand-green border-0">
          <h5 class="modal-title text-white">Upload Bukti Sebelum Menyelesaikan</h5>
          <button class="close" data-dismiss="modal" type="button" aria-label="Close">
            <span aria-hidden="true">x</span>
          </button>
        </div>

        <div class="modal-load p-4">
          <div class="row">
            <div class="col-12">
              <div class="text-center my-5">
                <i class="fa fa-spin fa-circle-notch fa-lg text-brand-green"></i>
                <h5 class="font-weight-light mb-3">Memuat...</h5>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-body p-4" style="display: none;">
        </div>
      </div>
    </div>
  </div>
  {{-- edit finish modal end --}}

  {{-- show modal --}}

  {{-- show modal end --}}

  @include('template.modal.konfirmasi_hapus')
  @include('template.modal.aktivitas_validasi_dikerjakan')
@endsection

@section('footjs')
  <!-- Plugins and scripts required by this view-->
  <!-- Image Preview -->
  <script src="{{ asset('js/image-preview.js') }}"></script>
  <!-- DataTables -->
  <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
  <!-- Bootstrap Datepicker -->
  <script src="{{ asset('vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
  <!-- Select2 -->
  <script src="{{ asset('vendor/select2/dist/js/select2.min.js') }}"></script>

  {{-- spofing http method --}}

  <!-- Page level custom scripts -->
  @include('template.footjs.kepegawaian.tooltip')
  @include('template.footjs.kepegawaian.add-training-speaker')
  @include('template.footjs.kepegawaian.datatables')
  @include('template.footjs.kepegawaian.datepicker')
  @include('template.footjs.kepegawaian.select-all')
  @include('template.footjs.kepegawaian.select2-multiple')
  @include('template.footjs.modal.get_delete')
  @include('template.footjs.modal.post_edit')
  @include('template.footjs.modal.put_ongoing')
  @include('template.footjs.modal.post_aktivity_finish')
@endsection
