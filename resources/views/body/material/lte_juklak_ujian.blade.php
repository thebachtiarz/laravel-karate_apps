@extends('layouts.masterlte')

@section('header')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('content')

<section class="content-header">
    <h1>Materi Ujian</h1>
    {!! createBreadcrumbByArrayOfCode(['materi']) !!}
</section>

<section class="content">
    @if((auth()->user()->status == 'bestnimda') || (auth()->user()->status == 'moderator') || (auth()->user()->status == 'treasurer') || (auth()->user()->status == 'instructor'))
    <div class="row">
        <div class="col-md-3">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Pilih Tingkat Materi</h3>
                </div>
                <div class="box-body">
                    <select class="form-control" id="selMateri">
                        @php $selID = 1 @endphp
                        <?php for ($i = 2; $i <= 10; $i++) : ?>
                            <?php if ($i != '9') : ?>
                                <option id="mtr{{$selID}}" value="{{ $i }}">Materi Kyu {{ $i }} / Sabuk {{ get_belt_by_kyu($i) }}</option>
                                @php $selID++ @endphp
                            <?php endif ?>
                        <?php endfor ?>
                    </select>
                    <div class="alert alert-info text-black zAlertResolution" style="margin-top: 5px; font-weight: bold; font-style: italic;">
                        Untuk Perangkat Smartphone Harap Download Materi Guna Resolusi Yang Lebih Baik.
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="box box-success">
                <div class="box-body" id="viewMateri"></div>
            </div>
        </div>
    </div>


    @else
    <div class="row">
        <div class="col-md-3">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Pilih Tingkat Materi</h3>
                </div>
                <div class="box-body">
                    <select class="form-control" id="selMateri">
                        @php $selID = 1 @endphp
                        @foreach($allowKyu as $kyu => $value)
                        <option id="mtr{{$selID}}" value="{{ $value }}">Materi Kyu {{ $value }} / Sabuk {{ get_belt_by_kyu($value) }}</option>
                        @php $selID++ @endphp
                        @endforeach
                    </select>
                    <div class="alert alert-info text-black zAlertResolution" style="margin-top: 5px; font-weight: bold; font-style: italic;">
                        Untuk Perangkat Smartphone Harap Download Materi Guna Resolusi Yang Lebih Baik.
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="box box-success">
                <div class="box-body" id="viewMateri"></div>
            </div>
        </div>
    </div>

    @endif
</section>

@endsection

@section('footer')
<script src="{{ asset('/js/juklak_materi.js') }}"></script>
@endsection