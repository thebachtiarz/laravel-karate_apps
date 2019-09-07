@extends('layouts.masterlte')

@section('header')
@endsection

@section('content')

<section class="content-header">
    <h1>Kelas</h1>
    {!! createBreadcrumbByArrayOfCode(['kelas']) !!}
    <div style="padding-top: 10px;"></div>
    @if(auth()->user()->status == 'moderator')<a type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_kelas"><i class="fas fa-plus"></i>&ensp;Tambah Kelas</a>@endif
</section>

<section class="content" id="data-kelas">
    <div class="row">
        @if($all_kelas)
        @foreach($all_kelas as $kelas)
        <div class="col-md-4">
            <div class="box box-widget widget-user">
                <div class="widget-user-header bg-black" style="background: url('{{ getKelasAvatar($kelas->kode_kelas) }}'); background-size: 100% 100%;">
                    <h3 class="widget-user-username">{{ $kelas->nama_kelas }}</h3>
                    <h5 class="widget-user-desc">{{ getCountPesertaByClassCode($kelas->kode_kelas) }} Peserta</h5>
                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-sm-4 border-right">
                            <div class="description-block">
                                <a href="{{ route('kelas.record.latihan') .'?key='. $kelas->kode_kelas }}" class="btn btn-primary btn-block"><i class="fas fa-running"></i>&ensp;Latihan</a>
                            </div>
                        </div>
                        <div class="col-sm-4 border-right">
                            <div class="description-block">
                                @if((auth()->user()->status == 'moderator') || (auth()->user()->status == 'treasurer'))
                                <a href="{{ route('moderator.payment.spp') .'?key='. $kelas->kode_kelas }}" class="btn btn-primary btn-block"><i class="fas fa-dollar-sign"></i>&ensp;SPP</a>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="description-block">
                                <a href="{{ route('kelas.record.persyaratan') .'?key='. $kelas->kode_kelas }}" class="btn btn-primary btn-block"><i class="fas fa-file-invoice-dollar"></i>&ensp;Persyaratan</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @endif
    </div>
</section>

@include('body.modal_form.lte_modal_based_auth')

@endsection

@section('footer')
<script src="/vendor/laravel-filemanager/js/lfm.js"></script>
<script>
    $(document).ready(function() {
        $('#lfm').filemanager('image');
    });
</script>
@endsection