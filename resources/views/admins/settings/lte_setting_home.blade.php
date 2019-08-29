@extends('layouts.masterlte')

@section('header')
@endsection

@section('content')

<section class="content-header">
    <h1>Apps Setting</h1>
    {!! createBreadcrumbByArrayOfCode(['setting']) !!}
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12 col-md-3">
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{ getCountUserTable() }}</h3>
                    <p>User</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="#usermanagement" class="small-box-footer hiddenReact page-scroll" value="usermanagement" data-ajaxjson="user">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-xs-12 col-md-3">
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{ getCountOfClassTable() }}</h3>
                    <p>Kelas</p>
                </div>
                <div class="icon">
                    <i class="fas fa-building"></i>
                </div>
                <a href="#classmanagement" class="small-box-footer  hiddenReact page-scroll" value="classmanagement" data-ajaxjson="class">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-xs-12 col-md-3">
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{ getCountOfNewGuests() }}</h3>
                    <p>Registrasi Baru</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <a href="#newregister" class="small-box-footer  hiddenReact page-scroll" value="newregister" data-ajaxjson="new_register">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-xs-12 col-md-3">
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>0</h3>
                    <p>Komplain</p>
                </div>
                <div class="icon">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
                <a href="#" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>
    <!-- set section for content value -->
    <section class="getHidden" id="usermanagement" hidden>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Users Management</h3>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <div class="thisDataJSON"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="getHidden" id="classmanagement" hidden>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Class Management</h3>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <div class="thisDataJSON"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="getHidden" id="newregister" hidden>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Register Management</h3>
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
<script src="{{ asset('js/prog_setting_admin.js') }}"></script>
@endsection