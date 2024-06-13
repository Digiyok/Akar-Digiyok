@extends('template.main.master')

@section('title')
PPA
@endsection

@section('headmeta')
<!-- Select2 -->
<link href="{{ asset('vendor/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendor/select2/dist/css/select2-bootstrap4.min.css') }}" rel="stylesheet">
<meta name="csrf-token" content="{{ Session::token() }}" />
@endsection

@section('sidebar')
@include('template.sidebar.keuangan.pengelolaan')
@endsection

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-2">
  <h1 class="h3 mb-0 text-gray-800">PPA</h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('keuangan.index')}}">Beranda</a></li>
    <li class="breadcrumb-item"><a href="{{ route('ppa.index')}}">PPA</a></li>
    <li class="breadcrumb-item"><a href="{{ route('ppa.index', ['jenis' => $jenisAktif->link])}}">{{ $jenisAktif->name }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('ppa.index', ['jenis' => $jenisAktif->link,'tahun' => !$isYear ? $tahun->academicYearLink : $tahun])}}">{{ !$isYear ? $tahun->academic_year : $tahun }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('ppa.index', ['jenis' => $jenisAktif->link,'tahun' => !$isYear ? $tahun->academicYearLink : $tahun, 'anggaran' => $anggaranAktif->anggaran->link])}}">{{ $anggaranAktif->anggaran->name }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('ppa.'.($ppaAktif->is_draft == 1 ? 'draft' : 'show'), ['jenis' => $jenisAktif->link,'tahun' => !$isYear ? $tahun->academicYearLink : $tahun, 'anggaran' => $anggaranAktif->anggaran->link, 'nomor' => $ppaAktif->firstNumber])}}">{{ $ppaAktif->firstNumber.($ppaAktif->is_draft == 1 ? ' (Draf)' : null) }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">Daftar Proposal</li>
  </ol>
</div>
{{--
<div class="row">
    @foreach($jenisAnggaran as $j)
    @php
    $checkAccAttr = $j->isKso ? 'director_acc_status_id' : 'president_acc_status_id';
    if(!in_array(Auth::user()->role->name,['pembinayys','ketuayys','direktur','fam','faspv','fas','am'])){
        if(Auth::user()->pegawai->unit_id == '5'){
            $anggaranCount = $j->anggaran()->whereHas('anggaran',function($q)use($checkAccAttr){$q->where('position_id',Auth::user()->pegawai->jabatan->group()->first()->id);})->whereHas('apby',function($q)use($checkAccAttr){$q->where($checkAccAttr,1);})->count();
        }
        else{
            $anggaranCount = $j->anggaran()->whereHas('anggaran',function($q)use($checkAccAttr){$q->where('unit_id',Auth::user()->pegawai->unit_id);})->whereHas('apby',function($q)use($checkAccAttr){$q->where($checkAccAttr,1);})->count();
            
        }
    }
    else{
        $anggaranCount = $j->anggaran()->whereHas('apby',function($q)use($checkAccAttr){$q->where($checkAccAttr,1);})->count();
    }
    @endphp
    @if($jenisAktif == $j)
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body p-0">
                <div class="row align-items-center mx-0">
                    <div class="col-auto px-3 py-2 bg-brand-green">
                        <i class="mdi mdi-file-document-outline mdi-24px text-white"></i>
                    </div>
                    <div class="col">
                        <div class="h6 mb-0 font-weight-bold text-gray-800">{{ $j->name }}</div>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn btn-sm btn-outline-secondary" disabled="disabled">Pilih</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    @if($anggaranCount > 0)
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body p-0">
                <div class="row align-items-center mx-0">
                    <div class="col-auto px-3 py-2 bg-brand-green">
                        <i class="mdi mdi-file-document-outline mdi-24px text-white"></i>
                    </div>
                    <div class="col">
                        <div class="h6 mb-0 font-weight-bold text-gray-800">{{ $j->name }}</div>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('ppa.index', ['jenis' => $j->link])}}" class="btn btn-sm btn-outline-brand-green">Pilih</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body p-0">
                <div class="row align-items-center mx-0">
                    <div class="col-auto px-3 py-2 bg-secondary">
                        <i class="mdi mdi-file-document-outline mdi-24px text-white"></i>
                    </div>
                    <div class="col">
                        <div class="h6 mb-0 font-weight-bold text-gray-800">{{ $j->name }}</div>
                    </div>
                    <div class="col-auto">
                        <a href="javascript:void(0)" class="btn btn-sm btn-outline-secondary disabled"role="button" aria-disabled="true">Pilih</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    @endif
    @endforeach
</div>
--}}
@if($jenisAktif)
<div class="row mb-4">
  <div class="col-12">
    <div class="card">
      <div class="card-body p-3">
        <div class="row mb-0">
          <div class="col-lg-8 col-md-10 col-12">
            <div class="form-group mb-0">
              <div class="row">
                <div class="col-lg-3 col-md-4 col-12">
                  <label class="form-control-label">Jenis</label>
                </div>
                <div class="col-lg-9 col-md-8 col-12">
                  {{ $ppaAktif->type_id ? $ppaAktif->type->name : '-' }}
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row mb-0">
          <div class="col-lg-8 col-md-10 col-12">
            <div class="form-group mb-0">
              <div class="row">
                <div class="col-lg-3 col-md-4 col-12">
                  <label class="form-control-label">Tanggal</label>
                </div>
                <div class="col-lg-9 col-md-8 col-12">
                  {{ $ppaAktif->dateId ? $ppaAktif->dateId : '-' }}
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row mb-0">
          <div class="col-lg-8 col-md-10 col-12">
            <div class="form-group mb-0">
              <div class="row">
                <div class="col-lg-3 col-md-4 col-12">
                  <label class="form-control-label">Nomor</label>
                </div>
                <div class="col-lg-9 col-md-8 col-12">
                  {{ $ppaAktif->number ? $ppaAktif->number : '-' }}
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row mb-0">
          <div class="col-lg-8 col-md-10 col-12">
            <div class="form-group mb-0">
              <div class="row">
                <div class="col-lg-3 col-md-4 col-12">
                  <label class="form-control-label">Tahap</label>
                </div>
                <div class="col-lg-9 col-md-8 col-12">
                  @if($ppaAktif->is_draft == 1)
                  <span class="badge badge-secondary">Draf</span>
                  @else
                  @if(!$ppaAktif->lppa)
                  <span class="badge badge-info">Diajukan</span>
                  @else
                  <span class="badge badge-success">Disetujui</span>
                  @endif
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row mb-0">
          <div class="col-lg-8 col-md-10 col-12">
            <div class="form-group mb-0">
              <div class="row">
                <div class="col-lg-3 col-md-4 col-12">
                  <label class="form-control-label">Akun Anggaran</label>
                </div>
                <div class="col-lg-9 col-md-8 col-12">
                  {{ $ppaDetail ? $ppaDetail->akun->codeName : '-' }}
                </div>
              </div>
            </div>
          </div>
        </div>
        @if($ppaAktif->lppaRef)
        <div class="row mb-0">
          <div class="col-lg-8 col-md-10 col-12">
            <div class="form-group mb-0">
              <div class="row">
                <div class="col-lg-3 col-md-4 col-12">
                  <label class="form-control-label">Nomor LPPA</label>
                </div>
                <div class="col-lg-9 col-md-8 col-12">
                  <a href="{{ route('lppa.show',['jenis' => $jenisAktif->link, 'tahun' => !$isYear ? $tahun->academicYearLink : $tahun, 'anggaran' => $anggaranAktif->anggaran->link, 'nomor' => $ppaAktif->lppaRef->firstNumber]) }}" target="_blank" class="text-decoration-none text-info">{{ $ppaAktif->lppaRef->number }}</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        @endif
        <div class="d-flex justify-content-end">
          <a href="{{ route('ppa.'.($ppaAktif->is_draft == 1 ? 'draft' : 'show'), ['jenis' => $jenisAktif->link, 'tahun' => !$isYear ? $tahun->academicYearLink : $tahun, 'anggaran' => $anggaranAktif->anggaran->link, 'nomor' => $ppaAktif->firstNumber]) }}" class="btn btn-sm btn-light">Kembali</a>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
    <div class="col-md-6 col-12 mb-4">
        <div class="card">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="mr-3">
                        <div class="icon-circle bg-brand-green">
                          <i class="fas fa-money-check text-white"></i>
                        </div>
                    </div>
                    <div>
                        <div class="small text-gray-500">Anggaran</div>
                        <h6 class="mb-0">{{ $anggaranAktif->anggaran->name }}</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-12 mb-4">
        <div class="card">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="mr-3">
                        <div class="icon-circle {{ $ppaDetail && $ppaDetail->proposals()->count() > 0 ? 'bg-brand-green' : 'bg-secondary' }}">
                          <i class="fas fa-calculator text-white"></i>
                        </div>
                    </div>
                    <div>
                        <div class="small text-gray-500">Jumlah</div>
                        <h6 id="summary" class="mb-0">
                            @if($ppaDetail && $ppaDetail->proposals()->count() > 0)
                            @if($ppaDetail->ppa->finance_acc_status_id != 1)
                            {{ number_format($ppaDetail->proposals()->sum('total_value'), 0, ',', '.') }}
                            @else
                            {{ $ppaDetail->valueWithSeparator }}
                            @endif
                            @else
                            0
                            @endif
                        </h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-12">
        <div class="card">
        <form action="{{ route('ppa.perbarui.semua.proposal',['jenis' => $jenisAktif->link, 'tahun' => !$isYear ? $tahun->academicYearLink : $tahun, 'anggaran' => $anggaranAktif->anggaran->link, 'nomor' => $ppaAktif->firstNumber, 'submitted' => $ppaAktif->is_draft == 1 ? null : '1', 'id' => $ppaDetail->id]) }}" id="ppa-form" method="post" enctype="multipart/form-data" accept-charset="utf-8">
          {{ csrf_field() }}
          {{ method_field('PUT') }}
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-brand-green">Proposal PPA</h6>
            </div>
            @if(Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show mx-3" role="alert">
              <strong>Sukses!</strong> {{ Session::get('success') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            @endif
            @if(Session::has('danger'))
            <div class="alert alert-danger alert-dismissible fade show mx-3" role="alert">
              <strong>Gagal!</strong> {{ Session::get('danger') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
               <span aria-hidden="true">&times;</span>
              </button>
            </div>
            @endif
            @yield('alert')
            @if($ppaAktif->detail()->count() > 0)
            <div class="table-responsive">
                <table id="proposalDetails" class="table align-items-center table-flush">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Deskripsi</th>
                            <th>Harga</th>
                            <th>Kuantitas</th>
                            <th>Subtotal</th>
                            @if(($apbyAktif && $apbyAktif->is_active == 1 && $apbyAktif->is_final != 1) && $isAnggotaPa && ((in_array(Auth::user()->role->name, ['fam','faspv','am']) && $ppaAktif->finance_acc_status_id != 1) || $ppaAktif->pa_acc_status_id != 1))
                            <th style="width: 160px">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                      @yield('row')
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
              @yield('footer')
            </div>
            @else
            <div class="text-center mx-3 my-5">
                <h3 class="text-center">Mohon Maaf,</h3>
                <h6 class="font-weight-light mb-3">Tidak ada data pengajuan yang ditemukan</h6>
            </div>
            <div class="card-footer"></div>
            @endif
        </form>
        </div>
    </div>
</div>
@endif
<!--Row-->

@if($ppaAktif && !$ppaAktif->lppa)
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-brand-green border-0">
        <h5 class="modal-title text-white" id="detailModalLabel">Detail Proposal PPA</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
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
@endif

<div class="modal fade" id="edit-form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-brand-green border-0">
        <h5 class="modal-title text-white">Ubah</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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

@if(($apbyAktif && $apbyAktif->is_active == 1 && $apbyAktif->is_final != 1) && $ppaAktif && $isAnggotaPa && ((in_array(Auth::user()->role->name, ['fam','faspv','am']) && $ppaAktif->finance_acc_status_id != 1) || $ppaAktif->pa_acc_status_id != 1))
<div class="modal fade" id="edit-detail-form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-brand-green border-0">
        <h5 class="modal-title text-white">Ubah Pengajuan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
        <form action="{{ route('ppa.perbarui.proposal', ['jenis' => $jenisAktif->link, 'tahun' => !$isYear ? $tahun->academicYearLink : $tahun, 'anggaran' => $anggaranAktif->anggaran->link, 'nomor' => $ppaAktif->firstNumber, 'submitted' => $ppaAktif->is_draft == 1 ? null : '1', 'id' => $ppaDetail->id]) }}" id="editPpaDetailForm" method="post" enctype="multipart/form-data" accept-charset="utf-8">
          {{ csrf_field() }}
          {{ method_field('PUT') }}
          <input type="hidden" name="editId">
          <div class="row">
            <div class="col-12">
              <div class="form-group">
                <div class="row mb-3">
                  <div class="col-lg-3 col-md-4 col-12">
                    <label for="normal-input" class="form-control-label">Deskripsi</label>
                  </div>
                  <div class="col-lg-9 col-md-8 col-12">
                    <input type="text" id="editDesc" class="form-control form-control-sm @error('editDesc') is-invalid @enderror" name="editDesc" value="{{ old('editDesc') }}" maxlength="255" required="required">
                    @error('editDesc')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="form-group">
                <div class="row">
                  <div class="col-lg-3 col-md-4 col-12">
                    <label for="normal-input" class="form-control-label">Harga</label>
                  </div>
                  <div class="col-lg-6 col-md-8 col-12">
                    <input type="text" id="editPrice" class="form-control form-control-sm @error('editPrice') is-invalid @enderror number-separator" name="editPrice" value="0" maxlength="15" required="required">
                    @error('editPrice')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="form-group">
                <div class="row">
                  <div class="col-lg-3 col-md-4 col-12">
                    <label for="normal-input" class="form-control-label">Jumlah</label>
                  </div>
                  <div class="col-lg-6 col-md-8 col-12">
                    <input type="text" id="editQty" class="form-control form-control-sm @error('editQty') is-invalid @enderror number-separator" name="editQty" value="1" maxlength="10" required="required">
                    @error('editQty')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row mt-1">
            <div class="col-12">
              <div class="row">
                <div class="col-lg-9 offset-lg-3 col-md-8 offset-md-4 col-12 text-left">
                  <input type="submit" class="btn btn-sm btn-brand-green-dark" value="Simpan">
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@include('template.modal.konfirmasi_hapus')

@endif

@endsection

@section('footjs')
<!-- Page level plugins -->

<!-- Easy Number Separator JS -->
<script src="{{ asset('vendor/easy-number-separator/easy-number-separator.js') }}"></script>

<!-- Plugins and scripts required by this view-->
@include('template.footjs.kepegawaian.tooltip')
@include('template.footjs.keuangan.change-year')

@if(($apbyAktif && $apbyAktif->is_active == 1 && $apbyAktif->is_final != 1) && $ppaAktif)
@if($isAnggotaPa && ((in_array(Auth::user()->role->name, ['fam','faspv','am']) && $ppaAktif->finance_acc_status_id != 1) || $ppaAktif->pa_acc_status_id != 1))
@include('template.footjs.modal.get_delete')
@include('template.footjs.modal.proposal_edit')
@endif
@if(($isAnggotaPa && ((in_array(Auth::user()->role->name, ['fam','faspv','am']) && $ppaAktif->finance_acc_status_id != 1) || $ppaAktif->pa_acc_status_id != 1)) || (!$isAnggotaPa && in_array(Auth::user()->role->name, ['fam','faspv','am']) && $ppaAktif->finance_acc_status_id != 1 && $ppaAktif->pa_acc_status_id == 1)))
<script>
    function editModal(route,proposal,modal = null) {
    var modalId = '#edit-form'; 
    if(modal) modalId = modal;
    
        $(modalId+' .modal-load').show();
        $(modalId+' .modal-body').hide();
            
        $.post(route,
        {
           '_token': $('meta[name=csrf-token]').attr('content'),
            proposal: proposal
        },
        function(response) {
            $(modalId+' .modal-body').html(response);
            $(modalId+' .modal-load').hide();
            $(modalId+' .modal-body').show();
        });
    }
</script>
@endif
@endif
@if($ppaAktif && !$ppaAktif->lppa)
@include('template.footjs.modal.post_detail')
@endif
@endsection