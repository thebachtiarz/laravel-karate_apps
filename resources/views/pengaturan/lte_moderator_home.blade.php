@extends('layouts.masterlte')

@section('header')
@endsection

@section('content')

<section class="content-header">
    <h1>Pengaturan</h1>
    {!! createBreadcrumbByArrayOfCode(['pengaturan']) !!}
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12 col-md-3">
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{ getCountOfModeratorClass() }}</h3>
                    <p>Kelas</p>
                </div>
                <div class="icon">
                    <i class="fas fa-building"></i>
                </div>
                <a href="#kelasmanagement" class="small-box-footer hiddenReact page-scroll" value="kelasmanagement" data-ajaxjson="kelas">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-xs-12 col-md-3">
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{ getCountModReqOtt() }}</h3>
                    <p>Permintaan Otentifikasi</p>
                </div>
                <div class="icon">
                    <i class="fas fa-file-signature"></i>
                </div>
                <a href="#reqotentifikasi" class="small-box-footer hiddenReact page-scroll" value="reqotentifikasi" data-ajaxjson="reqott">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>
    <section class="getHidden" id="kelasmanagement" hidden>
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Kelas Management</h3>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <div class="thisDataJSON"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="getHidden" id="reqotentifikasi" hidden>
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Permintaan Otentifikasi</h3>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <div class="thisDataJSON"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</section>
@endsection

@section('footer')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8.13.0/dist/sweetalert2.all.min.js" integrity="sha256-aakU0ciz46DahtBruJmV8isJWXw6TELTYFPcSVVcoFU=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
<script src="{{ asset('js/moderator_pengaturan.js') }}"></script>
@endsection