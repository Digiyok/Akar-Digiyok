@extends('template.main.sidebar')

@section('brand-system')
  Kepegawaian
@endsection

@section('sidebar-menu')
  <li class="nav-item {{ request()->routeIs('kepegawaian.index') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('kepegawaian.index') }}">
      <i class="mdi mdi-view-dashboard"></i>
      <span>Beranda</span></a>
  </li>
  <hr class="sidebar-divider">
  <div class="sidebar-heading">
    Manajemen Civitas
  </div>
  <li class="nav-item {{ request()->routeIs('pegawai*') ? 'active' : '' }}">
    <a class="nav-link {{ request()->routeIs('pegawai*') ? '' : 'collapsed' }}" data-toggle="collapse"
      data-target="#collapseCivitas" href="#" aria-expanded="{{ request()->routeIs('pegawai*') ? 'true' : 'false' }}"
      aria-controls="collapseCivitas">
      <i class="mdi mdi-tree"></i>
      <span>Civitas</span>
    </a>
    <div class="collapse {{ request()->routeIs('pegawai*') ? 'show' : '' }}" id="collapseCivitas"
      data-parent="#accordionSidebar" aria-labelledby="headingCivitas" style="">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Civitas</h6>
        <a class="collapse-item {{ request()->routeIs('pegawai*') && !isset($category) ? 'active' : '' }}"
          href="{{ route('pegawai.index') }}">
          <i class="mdi mdi-account-group"></i>
          <span>Semua</span>
        </a>
        <a class="collapse-item {{ request()->routeIs('pegawai*') && isset($category) && $category == 'pegawai' ? 'active' : '' }}"
          href="{{ route('pegawai.index', ['category' => 'pegawai']) }}">
          <i class="mdi mdi-account"></i>
          <span>Pegawai</span>
        </a>
        <a class="collapse-item {{ request()->routeIs('pegawai*') && isset($category) && $category == 'mitra' ? 'active' : '' }}"
          href="{{ route('pegawai.index', ['category' => 'mitra']) }}">
          <i class="mdi mdi-handshake"></i>
          <span>Mitra</span>
        </a>
        <a class="collapse-item {{ request()->routeIs('pegawai*') && isset($category) && $category == 'yayasan' ? 'active' : '' }}"
          href="{{ route('pegawai.index', ['category' => 'yayasan']) }}">
          <i class="mdi mdi-domain"></i>
          <span>Yayasan</span>
        </a>
      </div>
    </div>
  </li>
  <!--
        <li class="nav-item {{ request()->routeIs('calon*') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('calon.index') }}">
            <i class="mdi mdi-account-multiple-plus"></i>
            <span>Rekrutmen</span>
          </a>
        </li>
        <li class="nav-item {{ request()->routeIs('struktural*') || request()->routeIs('nonstruktural*') ? 'active' : '' }}">
          <a class="nav-link {{ request()->routeIs('struktural*') || request()->routeIs('nonstruktural*') ? '' : 'collapsed' }}" data-toggle="collapse" data-target="#collapsePenempatan" href="#" aria-expanded="{{ request()->routeIs('struktural*') || request()->routeIs('nonstruktural*') ? 'true' : 'false' }}" aria-controls="collapsePenempatan">
            <i class="mdi mdi-account-switch"></i>
            <span>Penempatan</span>
          </a>
          <div class="collapse {{ request()->routeIs('struktural*') || request()->routeIs('nonstruktural*') ? 'show' : '' }}" id="collapsePenempatan" data-parent="#accordionSidebar" aria-labelledby="headingPenempatan" style="">
            <div class="bg-white py-2 collapse-inner rounded">
              <h6 class="collapse-header">Penempatan</h6>
              <a class="collapse-item {{ request()->routeIs('struktural*') ? 'active' : '' }}" href="{{ route('struktural.index') }}">
                <i class="mdi mdi-account-tie"></i>
                <span>Struktural</span>
              </a>
              <a class="collapse-item {{ request()->routeIs('nonstruktural*') ? 'active' : '' }}" href="{{ route('nonstruktural.index') }}">
                <i class="mdi mdi-account"></i>
                <span>Nonstruktural</span>
              </a>
            </div>
          </div>
        </li>
        <li class="nav-item {{ request()->routeIs('pelatihan.materi*') || request()->routeIs('pelatihan.sertifikat*') ? 'active' : '' }}">
          <a class="nav-link {{ request()->routeIs('pelatihan.materi*') || request()->routeIs('pelatihan.sertifikat*') ? '' : 'collapsed' }}" data-toggle="collapse" data-target="#collapsePelatihan" href="#" aria-expanded="{{ request()->routeIs('pelatihan.materi*') || request()->routeIs('pelatihan.sertifikat*') ? 'true' : 'false' }}" aria-controls="collapsePelatihan">
            <i class="mdi mdi-clipboard-arrow-up"></i>
            <span>Pelatihan</span>
          </a>
          <div class="collapse {{ request()->routeIs('pelatihan.materi*') || request()->routeIs('pelatihan.sertifikat*') ? 'show' : '' }}" id="collapsePelatihan" data-parent="#accordionSidebar" aria-labelledby="headingPelatihan" style="">
            <div class="bg-white py-2 collapse-inner rounded">
              <h6 class="collapse-header">Pelatihan</h6>
              <a class="collapse-item {{ request()->routeIs('pelatihan.materi*') ? 'active' : '' }}" href="{{ route('pelatihan.materi.index') }}">
                <i class="mdi mdi-view-list"></i>
                <span>Pelatihan</span>
              </a>
              <a class="collapse-item {{ request()->routeIs('pelatihan.sertifikat*') ? 'active' : '' }}" href="{{ route('pelatihan.sertifikat.index') }}">
                <i class="mdi mdi-certificate"></i>
                <span>Sertifikat Kompetensi</span>
              </a>
            </div>
          </div>
        </li>
        <li class="nav-item {{ request()->routeIs('evaluasi*') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('evaluasi.index') }}">
            <i class="mdi mdi-account-switch"></i>
            <span>Evaluasi PTT</span>
          </a>
        </li>
        <li class="nav-item {{ request()->routeIs('phk*') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('phk.index') }}">
            <i class="mdi mdi-account-multiple-minus"></i>
            <span>Putus Hubungan Kerja</span>
          </a>
        </li>
        <hr class="sidebar-divider">
   <div class="sidebar-heading">
          Penilaian Kinerja
        </div>
        <li class="nav-item">
          <a class="nav-link collapsed" data-toggle="collapse" data-target="#collapsePSC" href="#" aria-expanded="false" aria-controls="collapsePSC">
            <i class="mdi mdi-star"></i>
            <span>Performance Scorecard</span>
          </a>
          <div class="collapse" id="collapsePSC" data-parent="#accordionSidebar" aria-labelledby="headingPSC" style="">
            <div class="bg-white py-2 collapse-inner rounded">
              <h6 class="collapse-header">Performance Scorecard</h6>
              <a class="collapse-item" href="alerts.html">
                <i class="mdi mdi-star-plus"></i>
                <span>Penilaian Kinerja</span>
              </a>
              <a class="collapse-item" href="alerts.html">
                <i class="mdi mdi-card-account-details-star"></i>
                <span>Laporan Prestasi Kerja</span>
              </a>
              <hr class="sidebar-divider">
              <a class="collapse-item" href="buttons.html">
                <i class="mdi mdi-cog"></i>
                <span>Aspek Evaluasi</span>
              </a>
              <a class="collapse-item" href="buttons.html">
                <i class="mdi mdi-cog"></i>
                <span>Rentang Nilai</span>
              </a>
            </div>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link collapsed" data-toggle="collapse" data-target="#collapseIKU" href="#" aria-expanded="false" aria-controls="collapseIKU">
            <i class="mdi mdi-flag"></i>
            <span>Indikator Kinerja Utama</span>
          </a>
          <div class="collapse" id="collapseIKU" data-parent="#accordionSidebar" aria-labelledby="headingIKU" style="">
            <div class="bg-white py-2 collapse-inner rounded">
              <h6 class="collapse-header">Indikator Kinerja Utama</h6>
              <a class="collapse-item" href="alerts.html">
                <i class="mdi mdi-flag-plus"></i>
                <span>IKU Edukasi</span>
              </a>
              <a class="collapse-item" href="alerts.html">
                <i class="mdi mdi-flag-plus"></i>
                <span>IKU Persepsi</span>
              </a>
              <a class="collapse-item" href="alerts.html">
                <i class="mdi mdi-flag-plus"></i>
                <span>IKU Sasaran</span>
              </a>
              <a class="collapse-item" href="alerts.html">
                <i class="mdi mdi-flag-plus"></i>
                <span>IKU Strategis</span>
              </a>
            </div>
          </div>
        </li>
        -->
  <hr class="sidebar-divider">
@endsection
