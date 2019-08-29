@extends('layouts.master')

@section('header')
<style>
    .btnMetric {
        margin-top: 5px;
    }
</style>
@endsection

@section('content')
<div class="main">
    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-headline">
                        <div class="panel-heading">
                            {{ createBreadcrumbByArrayOfCode(['pengaturan']) }}
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="metric">
                                        <span class="icon"><i class="fas fa-building"></i></span>
                                        <p>
                                            <span class="number"> Kelas</span>
                                            <span class="title"><a href="#kelasakses" value="kelasakses" data-ajaxjson="kelas" class="btn btn-primary btnMetric hiddenReact page-scroll">Kelola</a></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <section class="getHidden" id="kelasakses" hidden>
                        <div class="panel panel-headline">
                            <div class="panel-heading">
                                <h3 class="panel-title">Kelola Kelas</h3>
                                <p class="panel-subtitle">Daftar Kelas Anda</p>
                            </div>
                            <div class="panel-body thisDataJSON"></div>
                        </div>
                    </section>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8.13.0/dist/sweetalert2.all.min.js" integrity="sha256-aakU0ciz46DahtBruJmV8isJWXw6TELTYFPcSVVcoFU=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
<script src="{{ asset('js/moderator_pengaturan.js') }}"></script>
@endsection