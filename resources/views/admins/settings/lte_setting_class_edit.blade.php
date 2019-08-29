@extends('layouts.masterlte')

@section('header')
<style>
    .ImgResponsive {
        width: 100%;
        height: auto;
    }

    .GridButton {
        margin-bottom: 10px;
    }

    .b-secondary {
        background: #E2E3E5;
    }
</style>
@endsection

@section('content')

<section class="content-header">
    <h1>Kelas {{ getClassNameByCode($kelas_data['kode_kelas']) }}</h1>
    {!! createBreadcrumbByArrayOfCode(['kelas', $kelas_data['kode_kelas']]) !!}
</section>

<section class="content">
    <div class="row">
        <div class="col-md-5">
            <!-- Profile Image -->
            <div class="box box-primary">
                <img src="{{ getKelasAvatar($kelas_data['kode_kelas']) }}" class="ImgResponsive">
            </div>
        </div>
        <div class="col-md-7">
            <!-- About Me Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Info Kelas</h3>
                </div>
                <div class="box-body">
                    <i class="fas fa-building"></i>&ensp;<strong>Nama Kelas</strong>
                    <p class="text-muted">{{ $kelas_data['nama_kelas'] }}</p>
                    <i class="fas fa-user-secret"></i>&ensp;<strong>Pemilik</strong>
                    <p class="text-muted">{{ getNamePltByCode($kelas_data['kode_pelatih']) }}</p>
                    <i class="fas fa-chalkboard-teacher"></i>&ensp;<strong>Pelatih</strong>
                    <p class="text-muted">{{ getCountPelatihByClass($kelas_data['kode_kelas']) }} Pelatih</p>
                    <i class="fas fa-wallet"></i>&ensp;<strong>Bendahara</strong>
                    <p class="text-muted">{{ getCountBendaharaByClass($kelas_data['kode_kelas']) }} Bendahara</p>
                    <i class="fas fa-users"></i>&ensp;<strong>Peserta</strong>
                    <p class="text-muted">{{ getCountPesertaByClassCode($kelas_data['kode_kelas']) }} Peserta</p>
                    <i class="fas fa-clock"></i>&ensp;<strong>Didirikan</strong>
                    <p class="text-muted">{{ conv_getDate($kelas_data['created_at']) }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('footer')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8.13.0/dist/sweetalert2.all.min.js" integrity="sha256-aakU0ciz46DahtBruJmV8isJWXw6TELTYFPcSVVcoFU=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.js"></script>
<script src="{{ asset('js/prog_setting_admin.js') }}"></script>
@endsection