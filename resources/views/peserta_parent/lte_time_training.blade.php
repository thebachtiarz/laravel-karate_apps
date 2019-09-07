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
    <h1>Latihan</h1>
    {!! createBreadcrumbByArrayOfCode(['latihan']) !!}
</section>

<section class="content">
    @if(auth()->user()->status == 'participants')
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Riwayat {{ createThSmtInfoPeserta($thsmt) }}</h3>
            <div class="pull-right">
                <form action="" class="form-inline" method="get" accept-charset="ISO-8859-1">
                    <select class="form-control" id="thsmt" name="thsmt">
                        <option value="" disabled selected hidden>Semester</option>
                        {{ createOptSelectThSmtByClassAndCodePst(getClassCodeByPstCode(auth()->user()->code), auth()->user()->code, 'latihan') }}
                    </select>
                    <button type="submit" id="submitThSmt" hidden>Get Data</button>
                </form>
            </div>
        </div>
        <div class="box-header">
            {!! getProgresTrainBarByCodePst(getClassCodeByPstCode(auth()->user()->code), auth()->user()->code, $thsmt) !!}
        </div>
        <div class="box-body">
            {!! createPostTrainingPstByCode(auth()->user()->code, $thsmt) !!}
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
                        {{ createOptionSemesterForSearch($forthsmt) }}
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
        <section class="recordLatihan" id="{{$record->childs_code}}" hidden>
            <div class="box-header">
                {!! getProgresTrainBarByCodePst(getClassCodeByPstCode($record->childs_code), $record->childs_code, $thsmt) !!}
            </div>
            <div class="box-body">
                {!! createPostTrainingPstByCode($record->childs_code, $thsmt) !!}
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