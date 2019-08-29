@extends('layouts.masterlte')

@section('header')
<?php
if (isset($_GET['thsmt'])) {
    $thsmt = $_GET['thsmt'];
} else {
    $thsmt = '';
}
?>
@endsection

@section('content')

<section class="content-header">
    <h1>Persyaratan Ujian</h1>
    {!! createBreadcrumbByArrayOfCode(['persyaratan']) !!}
</section>

<section class="content">
    @if(auth()->user()->status == 'participants')
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Riwayat {{ createThSmtInfoPeserta($thsmt) }}</h3>
            <div class="pull-right">
                <form action="/persyaratan" class="form-inline" method="get" accept-charset="ISO-8859-1">
                    <select class="form-control" id="thsmt" name="thsmt">
                        <option value="" disabled selected hidden>Semester</option>
                        {{ createOptSelectThSmtByClassAndCodePst(getClassCodeByPstCode(auth()->user()->code), auth()->user()->code, 'persyaratan') }}
                    </select>
                    <button type="submit" id="submitThSmt" hidden>Get Data</button>
                </form>
            </div>
        </div>
        <div class="box-body">
            <div class="table-responsive no-padding">
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
                        {!! getSaldoBalancePstByClassAndCode(getClassCodeByPstCode(auth()->user()->code), auth()->user()->code, $thsmt) !!}
                    </tbody>
                </table>
            </div>
        </div>
        <div class="box-body">
            <div class="table-responsive no-padding">
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
                        {!! getRecFileExamnPstByClassAndCode(getClassCodeByPstCode(auth()->user()->code), auth()->user()->code, $thsmt) !!}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @elseif(auth()->user()->status == 'parents')
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">
                <?php
                if (isset($_GET['thsmt'])) {
                    $forthsmt = $_GET['thsmt'];
                } else {
                    $forthsmt = getThnSmtClassByCode(getClassCodeByPstCode($data[0]['childs_code']));
                }
                ?>
                Riwayat {{ createThSmtInfoPeserta($forthsmt) }}
            </h3>
            <div class="pull-right">
                <form action="" class="form-inline" method="get" accept-charset="ISO-8859-1">
                    <select class="form-control" id="thsmt" name="thsmt">
                        <option value="" disabled selected hidden>Semester</option>
                        {{ createOptionSemesterForSearch() }}
                    </select>
                    <button type="submit" id="submitThSmt" hidden>Get Data</button>
                </form>
            </div>
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
        <section class="recordPersyaratan" id="{{$record->childs_code}}" hidden>
            <div class="box-body">
                <div class="table-responsive no-padding">
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
                            {!! getSaldoBalancePstByClassAndCode(getClassCodeByPstCode($record->childs_code), $record->childs_code, $thsmt) !!}
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="box-body">
                <div class="table-responsive no-padding">
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
                            {!! getRecFileExamnPstByClassAndCode(getClassCodeByPstCode($record->childs_code), $record->childs_code, $thsmt) !!}
                        </tbody>
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