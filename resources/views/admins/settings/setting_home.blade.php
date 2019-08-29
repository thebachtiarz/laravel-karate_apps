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
                            {{ createBreadcrumbByArrayOfCode(['setting']) }}
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="metric">
                                        <span class="icon"><i class="fas fa-users-cog"></i></span>
                                        <p>
                                            <span class="number">{{ getCountUserTable() }} User</span>
                                            <span class="title"><a href="#usermanagement" value="usermanagement" data-ajaxjson="user" class="btn btn-primary btnMetric hiddenReact page-scroll">Kelola</a></span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="metric">
                                        <span class="icon"><i class="fas fa-building"></i></span>
                                        <p>
                                            <span class="number">{{ getCountOfClassTable() }} Kelas</span>
                                            <span class="title"><a href="#classmanagement" value="classmanagement" data-ajaxjson="class" class="btn btn-primary btnMetric hiddenReact page-scroll">Kelola</a></span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="metric">
                                        <span class="icon"><i class="fa fa-eye"></i></span>
                                        <p>
                                            <span class="number">274,678</span>
                                            <span class="title">Visits</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="metric">
                                        <span class="icon"><i class="fa fa-bar-chart"></i></span>
                                        <p>
                                            <span class="number">35%</span>
                                            <span class="title">Conversions</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <section class="getHidden" id="usermanagement" hidden>
                        <div class="panel panel-headline">
                            <div class="panel-heading">
                                <h3 class="panel-title">Kelola User</h3>
                                <p class="panel-subtitle">Total User Hingga Sekarang adalah {{ getCountUserTable() }} User</p>
                            </div>
                            <div class="panel-body thisDataJSON"></div>
                        </div>
                    </section>

                    <section class="getHidden" id="classmanagement" hidden>
                        <div class="panel panel-headline">
                            <div class="panel-heading">
                                <h3 class="panel-title">Kelola Kelas</h3>
                                <p class="panel-subtitle">Total Kelas Hingga Sekarang adalah {{ getCountOfClassTable() }} Kelas</p>
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
<script src="{{ asset('js/prog_setting_admin.js') }}"></script>
@endsection