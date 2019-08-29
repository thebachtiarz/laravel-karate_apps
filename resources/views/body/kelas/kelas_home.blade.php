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
    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="container-fluid">
            {{ createBreadcrumbByArrayOfCode(['kelas']) }}
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="right">
                                <a type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_kelas"><i class="fas fa-plus"></i>&ensp;Tambah Kelas</a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                @if($all_kelas)
                                @foreach($all_kelas as $kelas)
                                <div class="col-md-4">
                                    <div class="panel border-success">
                                        <img src="{{ getKelasAvatar($kelas->kode_kelas) }}" class="ImgResponsive">
                                        <div class="panel-body b-secondary">
                                            <h3 class="panel-title">{{ $kelas->nama_kelas }} :: {{ getCountPesertaByClassCode($kelas->kode_kelas) }} Peserta</h3>
                                        </div>
                                        <div class="panel-footer text-justify b-secondary">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <a href="{{ route('kelas.record.latihan') .'?key='. $kelas->kode_kelas }}" class="btn btn-primary btn-block GridButton"><i class="fas fa-book"></i>&ensp;Latihan</a>
                                                </div>
                                                <div class="col-sm-6">
                                                    <a href="{{ route('kelas.record.persyaratan') .'?key='. $kelas->kode_kelas }}" class="btn btn-success btn-block GridButton"><i class="fas fa-file-invoice-dollar"></i>&ensp;Persyaratan</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="add_kelas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="/kelas" method="POST" class="was-validated" enctype="multipart/form-data" accept-charset="ISO-8859-1">
                @csrf
                <div class="modal-header alert-info">
                    <h3 class="modal-title" id="exampleModalLabel">Tambah Kelas</h3>
                </div>
                <div class="modal-body">
                    <div class="form-group {{ $errors->has('nama_kelas') ? 'has-error' : '' }}">
                        <label for="nama_kelas">Nama Kelas</label>
                        <input type="text" class="form-control" id="nama_kelas" name="nama_kelas" placeholder="@if($errors->has('nama_kelas')){{ $errors->first('nama_kelas') }}@else{{ 'Nama Kelas' }}@endif" value="{{ old('nama_kelas') }}" onclick="this.placeholder=''" onblur="this.placeholder='@if($errors->has('nama_kelas')){{ $errors->first('nama_kelas') }}@else{{ 'Nama Kelas' }}@endif'">
                    </div>
                    <div class="form-group {{ $errors->has('durasi_latihan') ? 'has-error' : '' }}">
                        <label for="durasi_latihan">Durasi Latihan</label>
                        <select class="form-control" id="durasi_latihan" name="durasi_latihan">
                            <option value="" disabled selected hidden>@if($errors->has('durasi_latihan')){{ $errors->first('durasi_latihan') }}@else{{ 'Durasi Latihan' }}@endif</option>
                            <option value="96" {{ (old('durasi_latihan') == '96') ? 'selected' : '' }}>Full (96 jam = 6 bln) (Recomended)</option>
                            <option value="72" {{ (old('durasi_latihan') == '72') ? 'selected' : '' }}>72 Jam (2 Jam x 36 Hari)</option>
                            <option value="48" {{ (old('durasi_latihan') == '48') ? 'selected' : '' }}>48 Jam (2 Jam x 24 Hari)</option>
                            <option value="36" {{ (old('durasi_latihan') == '36') ? 'selected' : '' }}>36 Jam (2 Jam x 18 Hari)</option>
                            <option value="24" {{ (old('durasi_latihan') == '24') ? 'selected' : '' }}>24 Jam (2 Jam x 12 Hari)</option>
                        </select>
                    </div>
                    <label for="lfm">Gambar Kelas (jika ada)</label><br>
                    <div class="input-group {{ $errors->has('avatar') ? 'has-error' : '' }}">
                        <span class="input-group-btn">
                            <a id="lfm" data-input="avatar" data-preview="holder" class="btn btn-primary">
                                <i class="fa fa-picture-o"></i> Choose
                            </a>
                        </span>
                        <input id="avatar" class="form-control" type="text" name="avatar">
                        @if($errors->has('avatar'))<span class="help-block">{{ $errors->first('avatar') }}</span>@endif
                    </div>
                    <img id="holder" style="margin-top:15px;max-height:100px;">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('footer')
<script src="/vendor/laravel-filemanager/js/lfm.js"></script>
<script>
    $(document).ready(function() {
        $('#lfm').filemanager('image');
    });
</script>
@endsection