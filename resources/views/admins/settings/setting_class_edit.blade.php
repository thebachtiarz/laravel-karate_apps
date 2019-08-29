@extends('layouts.master')

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
<div class="main">
    <div class="main-content">
        <div class="container-fluid">
            <div class="panel panel-profile">
                <div class="clearfix">
                    <div class="profile-left">
                        <div class="profile-header">
                            <div class="overlay"></div>
                            <img src="{{ getKelasAvatar($kelas_data['kode_kelas']) }}" class="ImgResponsive">
                        </div>
                        <div class="profile-detail">
                            <div class="profile-info">
                                <h4 class="heading">Info Kelas</h4>
                                <ul class="list-unstyled list-justify">
                                    <li>Nama Kelas <span>{{ $kelas_data['nama_kelas'] }}</span></li>
                                    <li>Pemilik <span>{{ getNamePltByCode($kelas_data['kode_pelatih']) }}</span></li>
                                    <li>Didirikan <span>{{ conv_getDate($kelas_data['created_at']) }}</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="profile-right">
                        <h4 class="heading">Edit Kelas</h4>
                        <div class="awards">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('footer')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8.13.0/dist/sweetalert2.all.min.js" integrity="sha256-aakU0ciz46DahtBruJmV8isJWXw6TELTYFPcSVVcoFU=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script>
<script src="{{ asset('js/prog_setting_admin.js') }}"></script>

@endsection