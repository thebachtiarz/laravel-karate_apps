@extends('layouts.master')

@section('header')
<style>
    .padding_name {
        margin-top: 0px;
        margin-bottom: 0px;
    }

    .padding_prog {
        padding-top: 10px;
        margin-bottom: 0px;
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
                            <div class="row">
                                <div class="col-sm-7 padding_prog">
                                    {{ getProgresTrainBarByCodePst($data_peserta['kode_kelas_peserta'], $data_peserta['kode_peserta']) }}
                                </div>
                            </div>
                            <div class="right">
                                <a href="{{ route('kelas.record.latihan').'?key='.$data_peserta['kode_kelas_peserta'] }}" type="button" class="btn btn-primary"><i class="fas fa-long-arrow-alt-left"></i>&ensp;Kembali</a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-condensed">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Waktu</th>
                                            <th class="text-center">Durasi</th>
                                            <th class="text-center">Keterangan</th>
                                            <th class="text-center">Pelatih</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(json_decode($record_peserta) != NULL)
                                        @php $no = 1 @endphp
                                        @foreach($record_peserta as $rec)
                                        <tr>
                                            <td class="text-center">{{ $no }}</td>
                                            <td class="text-center">{{ conv_getDate($rec->created_at) }}</td>
                                            <td class="text-center">{{ $rec->durasi }} Jam</td>
                                            <td class="text-left">{{ $rec->keterangan }}</td>
                                            <td class="text-center">{{ getNamePltByCode($rec->kode_pelatih) }}</td>
                                        </tr>
                                        @php $no++ @endphp
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="5" class="text-center alert-danger"> Catatan Latihan Tidak Ditemukan ! </td>
                                        </tr>
                                        @endif
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

@endsection

@section('footer')
@endsection