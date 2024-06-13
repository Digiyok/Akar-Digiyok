@extends('template.main.master')

@section('title')
Profil Saya
@endsection

@section('sidebar')
@php
$role = Auth::user()->role->name;
@endphp
@if(in_array($role,['admin','am','aspv','direktur','etl','etm','fam','faspv','kepsek','pembinayys','ketuayys','wakasek','keulsi']))
@include('template.sidebar.kepegawaian.'.$role)
@else
@include('template.sidebar.kepegawaian.employee')
@endif
@endsection

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-2">
  <h1 class="h3 mb-0 text-gray-800">Profil Saya</h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="./">Akun</a></li>
    <li class="breadcrumb-item active" aria-current="page">Profil Saya</li>
  </ol>
</div>

<div class="row mb-4">
  <div class="col-12">
    <div class="card">
      <div class="card-body p-4">
        <div class="d-flex flex-row mb-2">
          <div class="photo-profile-circle d-inline-block"><img src="{{ asset(Auth::user()->pegawai->showPhoto) }}" alt="user-{{ Auth::user()->pegawai->id }}" class="avatar-img rounded-circle"></div>
          <div class="pl-3">
            <h3 class="font-weight-medium mt-md-3 mb-0">{{ Auth::user()->pegawai->name }}</h3>
            <span>{{ Auth::user()->pegawai->nip }}</span>
            <h5 class="mt-2 mb-0">
              @if(Auth::user()->pegawai->gender_id == '1')
              <span class="badge badge-info font-weight-normal">{{ ucwords(Auth::user()->pegawai->jenisKelamin->name) }}</span>
              @elseif(Auth::user()->pegawai->gender_id == '2')
              <span class="badge badge-brand-green font-weight-normal">{{ ucwords(Auth::user()->pegawai->jenisKelamin->name) }}</span>
              @endif
              @if(Auth::user()->pegawai->statusBaru && Auth::user()->pegawai->statusBaru->status == 'aktif' && !Auth::user()->pegawai->statusPhk)
              <span class="badge badge-primary font-weight-normal">Baru</span>
              @elseif(Auth::user()->pegawai->statusPhk && Auth::user()->pegawai->statusPhk->status == 'aktif')
              <span class="badge badge-warning font-weight-normal">PHK</span>
              @endif
            </h5>
          </div>
        </div>
      </div>
      <ul class="nav nav-tabs profile-tab" role="tablist">
        <li class="nav-item ml-3"> 
          <a class="nav-link active" href="{{ route('profil.index') }}">
            Profil Saya
          </a> 
        </li>
        <li class="nav-item"> 
          <a class="nav-link" href="{{ route('ubahsandi.index') }}">
            Ubah Sandi
          </a> 
        </li>
      </ul>
      <div class="card-body p-4">
        <div class="row mb-3">
          <div class="col-12">
            <h6 class="font-weight-bold text-brand-green">Info Umum</h6>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-10 col-md-12">
            <div class="row mb-3">
              <div class="col-lg-3 col-md-4 col-12">
                Nama Panggilan
              </div>
              <div class="col-lg-9 col-md-8 col-12">
                {{ Auth::user()->pegawai->nickname }}
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-10 col-md-12">
            <div class="row mb-3">
              <div class="col-lg-3 col-md-4 col-12">
                NIPY
              </div>
              <div class="col-lg-6 col-md-5 col-12">
                {{ Auth::user()->pegawai->nip }}
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-10 col-md-12">
            <div class="row mb-3">
              <div class="col-lg-3 col-md-4 col-12">
                NIK
              </div>
              <div class="col-lg-6 col-md-5 col-12">
                {{ Auth::user()->pegawai->nik }}
              </div>
            </div>
          </div>
        </div>
        @if(Auth::user()->pegawai->npwp)
        <div class="row">
          <div class="col-lg-10 col-md-12">
            <div class="row mb-3">
              <div class="col-lg-3 col-md-4 col-12">
                NPWP
              </div>
              <div class="col-lg-6 col-md-5 col-12">
                {{ Auth::user()->pegawai->npwp }}
              </div>
            </div>
          </div>
        </div>
        @endif
		    @if(Auth::user()->pegawai->nuptk)
        <div class="row">
          <div class="col-lg-10 col-md-12">
            <div class="row mb-3">
              <div class="col-lg-3 col-md-4 col-12">
                NUPTK
              </div>
              <div class="col-lg-6 col-md-5 col-12">
                {{ Auth::user()->pegawai->nuptk }}
              </div>
            </div>
          </div>
        </div>
        @endif
        @if(Auth::user()->pegawai->nrg)
        <div class="row">
          <div class="col-lg-10 col-md-12">
            <div class="row mb-3">
              <div class="col-lg-3 col-md-4 col-12">
                NRG
              </div>
              <div class="col-lg-6 col-md-5 col-12">
                {{ Auth::user()->pegawai->nrg }}
              </div>
            </div>
          </div>
        </div>
        @endif
        <div class="row">
          <div class="col-lg-10 col-md-12">
            <div class="row mb-3">
              <div class="col-lg-3 col-md-4 col-12">
                Jenis Kelamin
              </div>
              <div class="col-lg-9 col-md-8 col-12">
                {{ ucwords(Auth::user()->pegawai->jenisKelamin->name) }}
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-10 col-md-12">
            <div class="row mb-3">
              <div class="col-lg-3 col-md-4 col-12">
                Tempat, Tanggal Lahir
              </div>
              <div class="col-lg-7 col-md-6 col-12">
                {{ Auth::user()->pegawai->birth_place.', '.Auth::user()->pegawai->birthDateId }}
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-10 col-md-12">
            <div class="row mb-3">
              <div class="col-lg-3 col-md-4 col-12">
                Usia
              </div>
              <div class="col-lg-7 col-md-6 col-12">
                {{ Auth::user()->pegawai->age }}
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-10 col-md-12">
            <div class="row mb-3">
              <div class="col-lg-3 col-md-4 col-12">
                Status Pernikahan
              </div>
              <div class="col-lg-9 col-md-8 col-12">
                {{ ucwords(Auth::user()->pegawai->statusPernikahan->status) }}
              </div>
            </div>
          </div>
        </div>
        <hr>
        <div class="row mb-3">
          <div class="col-12">
            <h6 class="font-weight-bold text-brand-green">Info Alamat dan Kontak</h6>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-10 col-md-12">
            <div class="row mb-3">
              <div class="col-lg-3 col-md-4 col-12">
                Alamat
              </div>
              <div class="col-lg-9 col-md-8 col-12">
                {{ Auth::user()->pegawai->address . ', RT ' . sprintf('%03d',Auth::user()->pegawai->rt) . ' RW ' . sprintf('%03d',Auth::user()->pegawai->rw) . ', ' . Auth::user()->pegawai->alamat->name.', '.Auth::user()->pegawai->alamat->kecamatanName().', '.Auth::user()->pegawai->alamat->kabupatenName().', '.Auth::user()->pegawai->alamat->provinsiName() }}
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-10 col-md-12">
            <div class="row mb-3">
              <div class="col-lg-3 col-md-4 col-12">
                Email
              </div>
              <div class="col-lg-9 col-md-8 col-12">
                {{ Auth::user()->pegawai->email }}
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-10 col-md-12">
            <div class="row mb-3">
              <div class="col-lg-3 col-md-4 col-12">
                Nomor Seluler
              </div>
              <div class="col-lg-6 col-md-8 col-12">
                {{ Auth::user()->pegawai->phone_number }}
              </div>
            </div>
          </div>
        </div>
        <hr>
        <div class="row mb-3">
          <div class="col-12">
            <h6 class="font-weight-bold text-brand-green">Pendidikan</h6>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-10 col-md-12">
            <div class="row mb-3">
              <div class="col-lg-3 col-md-4 col-12">
                Pendidikan Terakhir
              </div>
              <div class="col-lg-9 col-md-8 col-12">
                {{ Auth::user()->pegawai->pendidikanTerakhir->name }}
              </div>
            </div>
          </div>
        </div>
        @if(Auth::user()->pegawai->latarBidangStudi)
        <div class="row">
          <div class="col-lg-10 col-md-12">
            <div class="row mb-3">
              <div class="col-lg-3 col-md-4 col-12">
                Program Studi
              </div>
              <div class="col-lg-9 col-md-8 col-12">
                {{ Auth::user()->pegawai->latarBidangStudi->name }}
              </div>
            </div>
          </div>
        </div>
        @endif
        @if(Auth::user()->pegawai->universitas)
        <div class="row">
          <div class="col-lg-10 col-md-12">
            <div class="row mb-3">
              <div class="col-lg-3 col-md-4 col-12">
                Universitas
              </div>
              <div class="col-lg-9 col-md-8 col-12">
                {{ Auth::user()->pegawai->universitas->name }}
              </div>
            </div>
          </div>
        </div>
        @endif
        <hr>
        <div class="row mb-3">
          <div class="col-12">
            <h6 class="font-weight-bold text-brand-green">Kepegawaian</h6>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-10 col-md-12">
            <div class="row mb-3">
              <div class="col-lg-3 col-md-4 col-12">
                Penempatan
              </div>
              <div class="col-lg-9 col-md-8 col-12">
                @if(Auth::user()->pegawai->units()->count() > 0)

                @php
                $unitCount = Auth::user()->pegawai->units()->count();
                @endphp

                @foreach(Auth::user()->pegawai->units()->orderBy('unit_id')->get() as $u)

                @php
                $penempatan = null;
                @endphp

                @if($u->jabatans()->count() > 0)

                @php
                $i = $u->jabatans()->count();
                @endphp

                @foreach($u->jabatans as $j)
                @php
                if($i == 1){
                  $penempatan .= $j->name;
                }
                else{
                  $penempatan .= $j->name.', ';
                }
                $i--;
                @endphp
                @endforeach

                @endif

                @php
                $unit = $penempatan ? $u->unit->name.' - '.$penempatan : $u->unit->name.' - Belum ditentukan';
                @endphp

                @if($unitCount == 1)
                {{ $unit }}
                @else
                {{ $unit }}<br>
                @endif

                @php
                $unitCount--;
                @endphp

                @endforeach

                @else
                Belum ditentukan
                @endif
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-10 col-md-12">
            <div class="row mb-3">
              <div class="col-lg-3 col-md-4 col-12">
                Status
              </div>
              <div class="col-lg-9 col-md-8 col-12">
                {{ Auth::user()->pegawai->statusPegawai->status }}
              </div>
            </div>
          </div>
        </div>
        @if(Auth::user()->pegawai->employee_status_id == 1 && (Auth::user()->pegawai->tetap && Auth::user()->pegawai->tetap->promotion_date))
        <div class="row">
          <div class="col-lg-10 col-md-12">
            <div class="row mb-3">
              <div class="col-lg-3 col-md-4 col-12">
                Tanggal Diangkat PT
              </div>
              <div class="col-lg-9 col-md-8 col-12">
                {{ Auth::user()->pegawai->tetap->promotionDateId }}
              </div>
            </div>
          </div>
        </div>
        @endif
        <div class="row">
          <div class="col-lg-10 col-md-12">
            <div class="row mb-3">
              <div class="col-lg-3 col-md-4 col-12">
                Bergabung Sejak
              </div>
              <div class="col-lg-9 col-md-8 col-12">
                {{ Auth::user()->pegawai->joinDateId }}
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-10 col-md-12">
            <div class="row mb-3">
              <div class="col-lg-3 col-md-4 col-12">
                Masa Kerja
              </div>
              <div class="col-lg-9 col-md-8 col-12">
                {{ Auth::user()->pegawai->yearsOfService }}
              </div>
            </div>
          </div>
        </div>
        @if(Auth::user()->pegawai->statusPegawai->id == 3 || Auth::user()->pegawai->statusPegawai->id == 4)
        <hr>
        <div class="row mb-3">
          <div class="col-12">
            <h6 class="font-weight-bold text-brand-green">Perjanjian Kerja</h6>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-10 col-md-12">
            <div class="row mb-3">
              <div class="col-lg-3 col-md-4 col-12">
                Nomor
              </div>
              <div class="col-lg-9 col-md-8 col-12">
                {{ Auth::user()->pegawai->spk()->latest()->first()->reference_number }}
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-10 col-md-12">
            <div class="row mb-3">
              <div class="col-lg-3 col-md-4 col-12">
                Masa Kerja
              </div>
              <div class="col-lg-9 col-md-8 col-12">
                {{ date('j F Y', strtotime(Auth::user()->pegawai->spk()->latest()->first()->period_start)) }} s.d. {{ date('j F Y', strtotime(Auth::user()->pegawai->spk()->latest()->first()->period_end)) }}
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-10 col-md-12">
            <div class="row mb-3">
              <div class="col-lg-3 col-md-4 col-12">
                Sisa Masa Kerja
              </div>
              <div class="col-lg-9 col-md-8 col-12">
                {{ Auth::user()->pegawai->spk()->latest()->first()->remainingPeriod }}
              </div>
            </div>
          </div>
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
@include('template.footjs.modal.post_edit')
@endsection