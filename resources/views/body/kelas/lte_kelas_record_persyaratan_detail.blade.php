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
        @if((auth()->user()->status == 'moderator') || (auth()->user()->status == 'treasurer'))<a type="button" class="btn btn-success" data-toggle="modal" data-target="#add_data"><i class="fas fa-plus"></i>&ensp;Tambah Data</a>@endif
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

@include('body.modal_form.lte_modal_based_auth')

@endsection

@section('footer')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8.13.0/dist/sweetalert2.all.min.js" integrity="sha256-aakU0ciz46DahtBruJmV8isJWXw6TELTYFPcSVVcoFU=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.js"></script>
<script src="{{ asset('js/moderator_record_persyaratan.js') }}"></script>
@endsection