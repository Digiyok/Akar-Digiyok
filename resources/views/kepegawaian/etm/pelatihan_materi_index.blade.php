@extends('template.main.master')

@section('title')
  Materi Pelatihan
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
    <h1 class="h3 mb-0 text-gray-800">Pelatihan</h1>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="./">Beranda</a></li>
      <li class="breadcrumb-item"><a href="{{ route('pelatihan.saya.index') }}">Pelatihan</a></li>
      <li class="breadcrumb-item active" aria-current="page">Materi</li>
    </ol>
  </div>

  <div class="row mb-4">
    <div class="col-12">
      <div class="card">
        <div class="card-body p-3">
          <form action="{{ route('pelatihan.materi.index') }}" method="get">
            <div class="row">
              <div class="col-lg-8 col-md-10 col-12">
                <div class="form-group mb-0">
                  <div class="row">
                    <div class="col-lg-3 col-md-4 col-12">
                      <label class="form-control-label" for="academicYearOpt">Tahun Pelajaran</label>
                    </div>
                    <div class="col-lg-9 col-md-8 col-12">
                      <select class="form-control" id="academicYearOpt" name="tahunajaran" aria-label="Tahun"
                        onchange="if(this.value){ this.form.submit(); }" required="required">
                        @foreach ($tahun as $t)
                          @if ($t->is_active == 1 || $t->pelatihan()->count() > 0)
                            <option value="{{ $t->academicYearLink }}" {{ $aktif->id == $t->id ? 'selected' : '' }}>
                              {{ $t->academic_year }}</option>
                          @endif
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="row mb-4">
    <div class="col-12">
      <div class="card">
        <ul class="nav nav-pills p-3">
          <li class="nav-item">
            <a class="nav-link active"
              href="{{ route('pelatihan.materi.index', ['tahunajaran' => $aktif->academicYearLink, 'status' => 'aktif']) }}">Aktif</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-brand-green"
              href="{{ route('pelatihan.materi.index', ['tahunajaran' => $aktif->academicYearLink, 'status' => 'selesai']) }}">Selesai</a>
          </li>
        </ul>
      </div>
    </div>
  </div>

  <div class="row mb-4">
    <div class="col-12">
      <div class="card">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-brand-green">Kurikulum Materi Pelatihan</h6>
          <button class="m-0 float-right btn btn-brand-green-dark btn-sm" data-toggle="modal" data-target="#add-form"
            type="button">Tambah <i class="fas fa-plus-circle ml-1"></i></button>
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
          @if (count($pelatihan) > 0)
            <div class="table-responsive">
              <table class="table align-items-center table-flush" id="dataTable">
                <thead class="thead-light">
                  <tr>
                    <th style="width: 15px">#</th>
                    <th>Materi</th>
                    <th>Deskripsi</th>
                    <th>Semester</th>
                    <th>Sifat</th>
                    <th>Status</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @php $no = 1; @endphp
                  @foreach ($pelatihan as $p)
                    <tr>
                      <td>{{ $no++ }}</td>
                      <td>
                        <a class="text-info detail-link" href="{{ route('pelatihan.materi.detail', ['id' => $p->id]) }}"
                          target="_blank">
                          {{ $p->name }}
                        </a>
                      </td>
                      <td>{{ $p->desc }}</td>
                      <td>
                        @if ($p->semester->semesterNumber == 1)
                          <span class="badge badge-pill badge-success">{{ $p->semester->semester }}</span>
                        @elseif($p->semester->semesterNumber == 2)
                          <span class="badge badge-pill badge-warning">{{ $p->semester->semester }}</span>
                        @else
                          -
                        @endif
                      </td>
                      <td>
                        @if ($p->status->status == 'wajib')
                          <span class="badge badge-pill badge-primary">{{ ucwords($p->status->status) }}</span>
                        @elseif($p->status->status == 'pilihan')
                          <span class="badge badge-pill badge-secondary">{{ ucwords($p->status->status) }}</span>
                        @else
                          -
                        @endif
                      </td>
                      <td>
                        @if ($p->education_acc_status_id == 2 && strtotime($p->education_acc_time) >= strtotime($p->updated_at))
                          <i class="fa fa-lg fa-exclamation-circle text-warning" data-toggle="tooltip"
                            data-original-title="Perlu Direvisi"></i>
                        @elseif($p->education_acc_status_id == 1)
                          <i class="fa fa-lg fa-check-circle text-success mr-1" data-toggle="tooltip" data-html="true"
                            data-original-title="Disetujui oleh {{ Auth::user()->pegawai->is($p->accEdukasi) ? 'Anda' : $p->accEdukasi->name }}<br>{{ date('j M Y H.i.s', strtotime($p->education_acc_time)) }}"></i>
                        @else
                          <i class="fa fa-lg fa-question-circle text-light" data-toggle="tooltip"
                            data-original-title="Menunggu Persetujuan ETL"></i>
                        @endif
                      </td>
                      <td>
                        <a class="btn btn-sm btn-primary" href="{{ route('pelatihan.materi.detail', ['id' => $p->id]) }}"
                          target="_blank"><i class="fas fa-eye"></i></a>
                        @if ($p->active_status_id != 2)
                          <a class="btn btn-sm btn-warning" data-toggle="modal" data-target="#edit-form"
                            href="#"
                            onclick="editModal('{{ route('pelatihan.materi.ubah') }}','{{ $p->id }}')"><i
                              class="fas fa-pen"></i></a>
                          @if ($p->education_acc_status_id != 1)
                            <a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete-confirm"
                              href="#"
                              onclick="deleteModal('Materi Pelatihan', '{{ addslashes(htmlspecialchars($p->name)) }}', '{{ route('pelatihan.materi.hapus', ['id' => $p->id]) }}')"><i
                                class="fas fa-trash"></i></a>
                          @endif
                        @endif
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @else
            <div class="text-center mx-3 mt-4 mb-5">
              <h3>Mohon Maaf,</h3>
              <h6 class="font-weight-light mb-3">Tidak ada data kurikulum materi yang ditemukan</h6>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
  <!--Row-->

  <div class="modal fade" id="add-form" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
    tabindex="-1" style="display: none;">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header bg-brand-green border-0">
          <h5 class="modal-title text-white">Tambah Materi Pelatihan</h5>
          <button class="close" data-dismiss="modal" type="button" aria-label="Close">
            <span aria-hidden="true">x</span>
          </button>
        </div>

        <div class="modal-body p-4">
          <form id="pelatihan-form" action="{{ route('pelatihan.materi.simpan') }}" method="post"
            enctype="multipart/form-data" accept-charset="utf-8">
            {{ csrf_field() }}
            <input id="tahunajaran" name="tahunajaran" type="hidden" value="{{ $aktif->academic_year }}"
              required="required">
            <div class="row mb-2">
              <div class="col-12">
                <div class="form-group">
                  <div class="row">
                    <div class="col-12">
                      <label class="form-control-label" for="normal-input">Materi Pelatihan <span
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
            <div class="row mb-2">
              <div class="col-12">
                <div class="form-group">
                  <div class="row">
                    <div class="col-12">
                      <label class="form-control-label" for="selectOrganizer">Penyelenggara <span
                          class="text-danger">*</span></label>
                    </div>
                    <div class="col-12">
                      <select class="form-control" id="selectOrganizer" name="organizer" required="required">
                        <option value="" {{ old('organizer') ? '' : 'selected' }} disabled="disabled">Pilih salah
                          satu</option>
                        @foreach ($unit as $u)
                          <option value="{{ $u->id }}" {{ old('organizer') == $u->id ? 'selected' : '' }}>
                            {{ $u->name }}</option>
                        @endforeach
                      </select>
                      @error('organizer')
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
                      <label class="form-control-label" for="speakerCategoryOpt">Jenis Narasumber <span
                          class="text-danger">*</span></label>
                    </div>
                    <div class="col-12">
                      <div class="custom-control custom-radio custom-control-inline">
                        <input class="custom-control-input" id="speakerCategoryOpt1" name="speaker_category"
                          type="radio" value="1" checked="checked" required="required">
                        <label class="custom-control-label" for="speakerCategoryOpt1">Pegawai</label>
                      </div>
                      <div class="custom-control custom-radio custom-control-inline">
                        <input class="custom-control-input" id="speakerCategoryOpt2" name="speaker_category"
                          type="radio" value="2" {{ old('speaker_name') ? 'checked' : '' }}
                          required="required">
                        <label class="custom-control-label" for="speakerCategoryOpt2">Lainnya</label>
                      </div>
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
                      <label class="form-control-label" for="selectSpeaker">Narasumber <span
                          class="text-danger">*</span></label>
                    </div>
                    <div class="col-12" id="speakerIdCol">
                      <select class="select2 form-control" id="selectSpeaker" name="speaker" required="required">
                        <option value="" {{ old('speaker') ? '' : 'selected' }} disabled="disabled">Pilih dari
                          daftar pegawai</option>
                        @foreach ($pegawai as $p)
                          <option value="{{ $p->id }}" {{ old('speaker') == $p->id ? 'selected' : '' }}>
                            {{ $p->name }}</option>
                        @endforeach
                      </select>
                      @error('speaker')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                    <div class="col-12" id="speakerNameCol" style="{{ old('speaker_name') ? '' : 'display: none' }}">
                      <input class="form-control" id="speakerName" name="speaker_name"
                        value="{{ old('speaker_name') }}" maxlength="255" placeholder="Nama lengkap narasumber"
                        {{ old('speaker_name') ? 'required="required"' : '' }}>
                      @error('speaker_name')
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
                      <label class="form-control-label" for="dateInput">Tanggal Pelaksanaan</label>
                    </div>
                    <div class="col-xl-8 col-md-9 col-12">
                      <div class="input-group date">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                        </div>
                        <input class="form-control" id="dateInput" name="date" type="text"
                          value="{{ old('date') }}" placeholder="Pilih tanggal">
                      </div>
                      @error('date')
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
                      <label class="form-control-label" for="normal-input">Tempat</label>
                    </div>
                    <div class="col-12">
                      <input class="form-control" id="place" name="place" maxlength="255">
                      @error('place')
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
                      <label class="form-control-label" for="select2Position">Sasaran <span
                          class="text-danger">*</span></label>
                    </div>
                    <div class="col-12">
                      <select class="select2-multiple form-control" id="select2Position" name="position[]"
                        multiple="multiple" required="required">
                        @foreach ($jabatan as $j)
                          <option value="{{ $j->id }}"
                            {{ old('position') ? (in_array($j->id, old('position')) ? 'selected' : '') : '' }}>
                            {{ $j->name }}</option>
                        @endforeach
                      </select>
                      <button class="btn btn-brand-green-dark btn-sm btn-select-all mt-2" data-target="select2Position"
                        type="button">Pilih Semua</button>
                      @error('position')
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
                      <label class="form-control-label" for="semesterOpt">Semester <span
                          class="text-danger">*</span></label>
                    </div>
                    <div class="col-12">
                      @foreach ($semester as $s)
                        <div class="custom-control custom-radio custom-control-inline">
                          <input class="custom-control-input" id="semesterOpt{{ $s->semesterNumber }}" name="semester"
                            type="radio" value="{{ $s->semesterNumber }}"
                            {{ old('semester') == $s->semesterNumber ? 'checked' : '' }} required="required">
                          <label class="custom-control-label"
                            for="semesterOpt{{ $s->semesterNumber }}">{{ ucwords($s->semester) }}</label>
                        </div>
                      @endforeach
                      @error('semester')
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
                      <label class="form-control-label" for="statusOpt">Sifat <span
                          class="text-danger">*</span></label>
                    </div>
                    <div class="col-12">
                      @foreach ($status as $s)
                        <div class="custom-control custom-radio custom-control-inline">
                          <input class="custom-control-input" id="statusOpt{{ $s->id }}" name="status"
                            type="radio" value="{{ $s->id }}" {{ old('status') == $s->id ? 'checked' : '' }}
                            required="required">
                          <label class="custom-control-label"
                            for="statusOpt{{ $s->id }}">{{ ucwords($s->status) }}</label>
                        </div>
                      @endforeach
                      @error('status')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                </div>
              </div>
            </div>
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

  <div class="modal fade" id="edit-form" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true"
    tabindex="-1" style="display: none;">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header bg-brand-green border-0">
          <h5 class="modal-title text-white">Ubah Materi Pelatihan</h5>
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

  @include('template.modal.konfirmasi_hapus')

@endsection

@section('footjs')
  <!-- Plugins and scripts required by this view-->

  <!-- Page level plugins -->

  <!-- DataTables -->
  <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
  <!-- Bootstrap Datepicker -->
  <script src="{{ asset('vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
  <!-- Select2 -->
  <script src="{{ asset('vendor/select2/dist/js/select2.min.js') }}"></script>

  <!-- Page level custom scripts -->
  @include('template.footjs.kepegawaian.tooltip')
  @include('template.footjs.kepegawaian.add-training-speaker')
  @include('template.footjs.kepegawaian.datatables')
  @include('template.footjs.kepegawaian.datepicker')
  @include('template.footjs.kepegawaian.select-all')
  @include('template.footjs.kepegawaian.select2-multiple')
  @include('template.footjs.modal.get_delete')
  @include('template.footjs.modal.post_edit')
@endsection
