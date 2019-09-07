@extends('layouts.masterlte')

@section('header')
@endsection

@section('content')

<section class="content-header">
    <h1>SPP</h1>
    {!! createBreadcrumbByArrayOfCode(['spp_peserta']) !!}
</section>

<section class="content">
    @if(auth()->user()->status == 'participants')
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Riwayat SPP Bulanan</h3>
        </div>
        <div class="box-body">
            <div class="box-body table-responsive no-padding bodyRecSppPst">
                <table class="table table-hover table-condensed">
                    <thead class="bg-primary">
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Waktu</th>
                            <th class="text-center">Kredit</th>
                            <th class="text-center">Keterangan</th>
                            <th class="text-center">Penanggung Jawab</th>
                        </tr>
                    </thead>
                    <tbody>@if(getRecSppPstByClassAndCodeInTbody(getClassCodeByPstCode(auth()->user()->code), auth()->user()->code) != NULL)
                        {!! implode('', getRecSppPstByClassAndCodeInTbody(getClassCodeByPstCode(auth()->user()->code), auth()->user()->code)) !!}
                        @else {!! '<tr>
                            <td colspan="5" class="text-center alert-danger" style="font-weight: bold;">Tidak Ada Record SPP</td>
                        </tr>' !!} @endif</tbody>
                </table>
            </div>
        </div>
    </div>

    @elseif(auth()->user()->status == 'parents')
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Riwayat SPP Bulanan</h3>
            <div class="pull-right">
                <select class="form-control" id="selPeserta">
                    @php $selID = 1 @endphp
                    @foreach($data as $recVal)
                    <option id="pst{{$selID}}" value="{{ $recVal->childs_code }}">{{ getNamePstByCode($recVal->childs_code) }}</option>
                    @php $selID++ @endphp
                    @endforeach
                </select>
            </div>
        </div>
        @foreach($data as $record)
        <section class="recordSpp" id="{{ $record->childs_code }}" hidden>
            <div class="box-body">
                <div class="box-body table-responsive no-padding bodyRecSppPst">
                    <table class="table table-hover table-condensed">
                        <thead class="bg-primary">
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Waktu</th>
                                <th class="text-center">Kredit</th>
                                <th class="text-center">Keterangan</th>
                                <th class="text-center">Penanggung Jawab</th>
                            </tr>
                        </thead>
                        <tbody>@if(getRecSppPstByClassAndCodeInTbody(getClassCodeByPstCode($record->childs_code), $record->childs_code) != NULL)
                            {!! implode('', getRecSppPstByClassAndCodeInTbody(getClassCodeByPstCode($record->childs_code), $record->childs_code)) !!}
                            @else
                            {!! '<tr>
                                <td colspan="5" class="text-center alert-danger" style="font-weight: bold;">Tidak Ada Record SPP</td>
                            </tr>' !!}
                            @endif</tbody>
                    </table>
                </div>
            </div>
        </section>
        @endforeach
    </div>
    @else
    @endif
</section>

@endsection

@section('footer')
<script src="{{ asset('js/peserta_parent_latihan_persyaratan.js') }}"></script>
@endsection