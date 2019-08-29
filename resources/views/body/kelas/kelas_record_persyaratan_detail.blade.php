@extends('layouts.master')

@section('header')
<style>
    .btn-modal {
        margin-right: 0px !important;
    }
</style>
@endsection

@section('content')
<div class="main">
    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="container-fluid">
            {{ createBreadcrumbByArrayOfCode(['kelas', $data_peserta['kode_kelas_peserta'], $data_peserta['kode_peserta']]) }}
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="right">
                                <a href="{{ route('kelas.record.persyaratan').'?key='.$data_peserta['kode_kelas_peserta'] }}" type="button" class="btn btn-primary"><i class="fas fa-long-arrow-alt-left"></i>&ensp;Kembali</a>
                                <a type="button" class="btn btn-success" data-toggle="modal" data-target="#add_data"><i class="fas fa-plus"></i>&ensp;Tambah Data</a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-condensed">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Waktu</th>
                                            <th class="text-center">Kredit</th>
                                            <th class="text-center">Saldo</th>
                                            <th class="text-center">Penanggung Jawab</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {!! getSaldoBalancePstByClassAndCode($data_peserta['kode_kelas_peserta'], $data_peserta['kode_peserta']) !!}
                                        <tr>
                                            <td colspan="2"></td>
                                            <td colspan="3" class="text-right">
                                                Saldo Rp. {{ mycurrency(get_lastSaldoUser_by_code($data_peserta['kode_kelas_peserta'], $data_peserta['kode_peserta'])) }},-&ensp;Biaya Ujian&ensp;Rp. {{ mycurrency(getCostExamnPstByClassAndCode($data_peserta['kode_kelas_peserta'], $data_peserta['kode_peserta'])) }},-&ensp;Kurang&ensp;Rp. {{ mycurrency(getExamnLessPaymentPst(getCostExamnPstByClassAndCode($data_peserta['kode_kelas_peserta'], $data_peserta['kode_peserta']), get_lastSaldoUser_by_code($data_peserta['kode_kelas_peserta'], $data_peserta['kode_peserta']))) }},-
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="panel">
                        <div class="panel-heading">

                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
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
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="add_data" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header alert-info">
                <h3 class="modal-title" id="exampleModalLabel">Tambah Data Persyaratan</h3>
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
                            <div class="form-group {{ $errors->has('kredit') ? 'has-error' : '' }}">
                                <input type="text" inputmode="numeric" class="form-control is-invalid" id="rupiah" placeholder="@if($errors->has('kredit')){{ 'Nominal Jumlah Kredit Salah' }}@else{{ 'Jumlah Kredit' }}@endif" minlength="5" maxlength="13" onclick="this.placeholder=''" onblur="this.placeholder='@if($errors->has('kredit')){{ 'Nominal Jumlah Kredit Salah' }}@else{{ 'Jumlah Kredit' }}@endif'">
                                <input type="hidden" inputmode="text" class="form-control" id="creditpst" name="kredit" value="" minlength="4" maxlength="6" readonly>
                            </div>
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

<script>
    var rupiah = document.getElementById("rupiah");
    rupiah.addEventListener("keyup", function(e) {
        rupiah.value = formatRupiah(this.value, "Rp. ");
    });

    function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, "").toString(),
            split = number_string.split(","),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);
        if (ribuan) {
            separator = sisa ? "." : "";
            rupiah += separator + ribuan.join(".");
        }
        rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
        return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
    }
</script>

<script>
    $("#rupiah").keyup(function() {
        var kalimat = $('#rupiah').val();
        var ganti = kalimat.replace(/[.*+?^${}()|[\]\\]/g, '');
        var res = ganti.slice(3, 10);
        $('#creditpst').val(res);
    });
</script>
@endsection