@extends('layouts.masterlte')

@section('header')
@endsection

@section('content')

<section class="content-header">
    <h1>Detail Persyaratan</h1>
    {!! createBreadcrumbByArrayOfCode(['kelas', $data_peserta['kode_kelas_peserta'], $data_peserta['kode_peserta']]) !!}
    <div style="padding-top: 10px;"></div>
    <p>
        <a href="{{ route('kelas.record.persyaratan').'?key='.$data_peserta['kode_kelas_peserta'] }}" type="button" class="btn btn-primary"><i class="fas fa-long-arrow-alt-left"></i>&ensp;Kembali</a>
        <a type="button" class="btn btn-success" data-toggle="modal" data-target="#add_data"><i class="fas fa-plus"></i>&ensp;Tambah Data</a>
    </p>
    <div style="padding-top: 10px;"></div>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover table-condensed">
                        <thead class="bg-primary">
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Waktu</th>
                                <th class="text-center">Kredit</th>
                                <th class="text-center">Keterangan</th>
                                <th class="text-center">Saldo</th>
                                <th class="text-center">Penanggung Jawab</th>
                            </tr>
                        </thead>
                        <tbody>
                            {!! getSaldoBalancePstByClassAndCode($data_peserta['kode_kelas_peserta'], $data_peserta['kode_peserta']) !!}
                            <tr>
                                <td colspan="3"></td>
                                <td colspan="3" class="text-right">
                                    {!! getKeteranganPaymentExamnByCodeAndClass($data_peserta['kode_kelas_peserta'], $data_peserta['kode_peserta']) !!}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover table-condensed">
                        <thead class="bg-primary">
                            <tr>
                                <th class="text-center">Jenis</th>
                                <th class="text-center">Diserahkan</th>
                                <th class="text-center">Keterangan</th>
                                <th class="text-center">Penanggung Jawab</th>
                            </tr>
                        </thead>
                        <tbody>
                            {!! getRecFileExamnPstByClassAndCode($data_peserta['kode_kelas_peserta'], $data_peserta['kode_peserta']) !!}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="add_data" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header alert-info">
                <h3 class="modal-title" id="exampleModalLabel">Tambah Data Persyaratan</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('kelas.record.persyaratan') }}" method="POST" class="was-validated" accept-charset="ISO-8859-1">
                    @csrf<input type="hidden" name="kode_kelas" value="{{ $data_peserta['kode_kelas_peserta'] }}" readonly><input type="hidden" name="kode_peserta" value="{{ $data_peserta['kode_peserta'] }}" readonly>
                    <div class="row mx-1">
                        <div class="col-sm-12">
                            <h4>Persyaratan Biaya Ujian</h4>
                        </div>
                    </div>
                    <div class="row mx-1 pt-1">
                        <div class="col-sm-12 col-md-4 col-lg-3">Kredit</div>
                        <div class="col-sm-12 col-md-8 col-lg-9">
                            @if(getCostExamnPstByClassAndCode($data_peserta['kode_kelas_peserta'], $data_peserta['kode_peserta']))
                            @if(get_lastSaldoUser_by_code($data_peserta['kode_kelas_peserta'], $data_peserta['kode_peserta']) < getCostExamnPstByClassAndCode($data_peserta['kode_kelas_peserta'], $data_peserta['kode_peserta'])) <div class="form-group {{ $errors->has('kredit') ? 'has-error' : '' }}">
                                <input type="text" inputmode="numeric" class="form-control is-invalid" id="rupiah" placeholder="@if($errors->has('kredit')){{ 'Nominal Jumlah Kredit Salah' }}@else{{ 'Jumlah Kredit' }}@endif" minlength="5" maxlength="13" onclick="this.placeholder=''" onblur="this.placeholder='@if($errors->has('kredit')){{ 'Nominal Jumlah Kredit Salah' }}@else{{ 'Jumlah Kredit' }}@endif'">
                                <input type="hidden" inputmode="text" class="form-control" id="creditpst" name="kredit" value="" minlength="4" maxlength="6" readonly>
                                {!! getKeteranganPaymentExamnByCodeAndClass($data_peserta['kode_kelas_peserta'], $data_peserta['kode_peserta']) !!}
                        </div>
                        @else
                        <h4 class="text-primary text-bold">Pembayaran Sudah Lunas!</h4>
                        @endif
                        @else
                        <h4 class="text-warning text-bold">Biaya Ujian Belum Ditentukan!</h4>
                        @endif
                    </div>
            </div>
            <div class="row mx-1 pt-3">
                <div class="col-sm-12 btn-modal"><button type="submit" class="btn btn-primary" name="type" value="budget"><i class="fas fa-credit-card"></i>&ensp;Proses</button></div>
            </div>
            </form>
            <hr class="mx-1">
            <form action="{{ route('kelas.record.persyaratan') }}" method="POST" class="was-validated" accept-charset="ISO-8859-1">
                @csrf<input type="hidden" name="kode_kelas" value="{{ $data_peserta['kode_kelas_peserta'] }}" readonly><input type="hidden" name="kode_peserta" value="{{ $data_peserta['kode_peserta'] }}" readonly>
                <div class="row mx-1">
                    <div class="col-sm-12">
                        <h4>Persyaratan File Dokumen</h4>
                    </div>
                </div>
                <div class="row mx-1 pt-1">
                    <div class="col-sm-12 col-md-4 col-lg-3"><label for="kode_file">Jenis</label></div>
                    <div class="col-sm-12 col-md-8 col-lg-9">
                        <div class="form-group {{ $errors->has('kode_file') ? 'has-error' : '' }}">
                            <select class="form-control" id="kode_file" name="kode_file">
                                <option value="" disabled selected hidden>@if($errors->has('kode_file')){{ 'Jenis Persyaratan Harus Ada' }}@else{{ 'Jenis Persyaratan' }}@endif</option>
                                {!! getExamnFileReqHaveNotBeenCollectedByCodePst($data_peserta['kode_kelas_peserta'], $data_peserta['kode_peserta'], old('kode_file')) !!}
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mx-1 pt-1">
                    <div class="col-sm-12 col-md-4 col-lg-3"><label for="file_info">Keterangan</label></div>
                    <div class="col-sm-12 col-md-8 col-lg-9">
                        <div class="form-group {{ $errors->has('file_info') ? 'has-error' : '' }}">
                            <input type="text" class="form-control is-invalid" id="file_info" name="file_info" placeholder="@if($errors->has('file_info')){{ 'Masukkan Keterangan Kelengkapan' }}@else{{ 'Keterangan kelengkapan' }}@endif" onclick="this.placeholder=''" onblur="this.placeholder='@if($errors->has('file_info')){{ 'Masukkan Keterangan Kelengkapan' }}@else{{ 'Keterangan kelengkapan' }}@endif'">
                        </div>
                    </div>
                </div>
                <div class="row mx-1 pt-3">
                    <div class="col-sm-12"><button type="submit" class="btn btn-primary" name="type" value="file"><i class="fas fa-archive"></i>&ensp;Simpan</button></div>
                </div>
            </form>
        </div>
        <div class="modal-footer alert-info">
        </div>
    </div>
</div>
</div>

@endsection

@section('footer')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8.13.0/dist/sweetalert2.all.min.js" integrity="sha256-aakU0ciz46DahtBruJmV8isJWXw6TELTYFPcSVVcoFU=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.js"></script>
<script src="{{ asset('js/moderator_record_persyaratan.js') }}"></script>
@endsection