@extends('layouts.masterlte')

@section('header')
@endsection

@section('content')

<section class="content-header">
    <h1>Detail Latihan</h1>
    {!! createBreadcrumbByArrayOfCode(['kelas', $data_peserta['kode_kelas_peserta'], $data_peserta['kode_peserta']]) !!}
    <div style="padding-top: 10px;"></div>
    <div class="row">
        <div class="col-md-5">
            <a href="{{ route('kelas.record.latihan').'?key='.$data_peserta['kode_kelas_peserta'] }}" type="button" class="btn btn-primary"><i class="fas fa-long-arrow-alt-left"></i>&ensp;Kembali</a>
            <div style="padding-bottom: 10px;"></div>
        </div>
        <div class="col-md-7">
            {{ getProgresTrainBarByCodePst($data_peserta['kode_kelas_peserta'], $data_peserta['kode_peserta']) }}
        </div>
    </div>
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
                                <td class="text-left">{{ getKetLatihanByCode($rec->keterangan) }}</td>
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
</section>

@endsection

@section('footer')
@endsection