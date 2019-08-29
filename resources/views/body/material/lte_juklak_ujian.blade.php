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
                        <?php for ($i = 1; $i <= 10; $i++) : ?>
                        <?php if ($i != '9') : ?>
                        <option id="mtr{{$selID}}" value="{{ $i }}">Materi Kyu {{ $i }} / Sabuk {{ get_belt_by_kyu($i) }}</option>
                        @php $selID++ @endphp
                        <?php endif ?>
                        <?php endfor ?>
                    </select>
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
<script>
    // autoselect peserta when reload
    $(document).ready(function() {
        $('#mtr1').attr('selected', true);
        getMateriPeserta($('#mtr1').val());
    });

    // select materi peserta
    $('#selMateri').on('change', function() {
        let kyuMateri = $("#selMateri option:selected").val();
        getMateriPeserta(kyuMateri);
    });

    // function get materi peserta by kyu
    function getMateriPeserta(tingkat) {
        let progress = '<div class="progress progress-sm active"><div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div></div>';
        $('#viewMateri').html(progress);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: '/materi/get',
            data: {
                kyu: tingkat
            },
            success: function(data) {
                $('#viewMateri').html(data);
            }
        });
    }
</script>
@endsection