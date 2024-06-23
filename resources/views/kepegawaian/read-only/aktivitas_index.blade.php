@extends('template.main.master')

@section('title')
  Aktifitas Pegawai
@endsection

@section('sidebar')
  @include('template.sidebar.kepegawaian.' . Auth::user()->role->name)
@endsection

@section('content')
  <div class="d-sm-flex align-items-center justify-content-between mb-2">
    <h1 class="h3 mb-0 text-gray-800">Aktivitas Pegawai</h1>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="./">Beranda</a></li>
      <li class="breadcrumb-item"><a href="{{ route('penempatan.index') }}">Penempatan</a></li>
      <li class="breadcrumb-item active" aria-current="page">Struktural</li>
    </ol>
  </div>

  <div class="row mb-4">
    <div class="col-12">
      <div class="card">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-brand-green">Department Tersedia</h6>
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

          @if (count($department) > 0)
            <div class="row ml-1">
              @foreach ($department as $d)
                <div class="col-md-6 col-12 mb-3">
                  <div class="row py-2 rounded border border-light mr-2">
                    <div class="col-8 d-flex align-items-center">
                      <div class="mr-3">
                        <div class="icon-circle bg-gray-500">
                          <i class="fas fa-school text-white"></i>
                        </div>
                      </div>
                      <div>
                        <a class="font-weight-bold text-dark"
                          href="{{ route('aktivitas.create', ['status' => 1, 'department' => $d->department->name]) }}">
                          {{ $d->department->name }}
                        </a>
                      </div>
                    </div>
                    <div class="col-4 d-flex justify-content-end align-items-center">
                      <a class="btn btn-sm btn-outline-brand-green-dark"
                        href="{{ route('aktivitas.create', ['status' => 1, 'department' => $d->department->name]) }}">Pilih</a>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          @else
            <div class="text-center mx-3 mt-4 mb-5">
              <h3>Mohon Maaf,</h3>
              <h6 class="font-weight-light mb-3">Tidak ada data unit yang ditemukan</h6>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
  <!--Row-->
@endsection

@section('footjs')
  <!-- Plugins and scripts required by this view-->

  <!-- Page level custom scripts -->
  @include('template.footjs.kepegawaian.tooltip')
@endsection
