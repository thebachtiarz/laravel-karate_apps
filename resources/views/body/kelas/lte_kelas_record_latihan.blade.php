@extends('layouts.masterlte')

@section('header')
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="{{ online_asset() }}/plugins/iCheck/all.css">
@endsection

@section('content')

<section class="content-header">
    <h1>Record Latihan</h1>
    {!! createBreadcrumbByArrayOfCode(['kelas', $kelas]) !!}
    <div style="padding-top: 10px;"></div>
    @if((auth()->user()->status == 'moderator') || (auth()->user()->status == 'treasurer') || (auth()->user()->status == 'instructor'))<a type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_peserta"><i class="fas fa-plus"></i>&ensp;Tambah Peserta</a>@endif
</section>

<section class="content">
    <form class="was-validated" action="/kelas/record/latihan" method="post" accept-charset="ISO-8859-1">
        @csrf<input type="hidden" name="class_code" value="{{ $kelas }}" readonly>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <thead class="bg-primary">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Nama</th>
                                    <th class="text-center">Tingkatan</th>
                                    <th class="text-center">Persentase</th>
                                    <th class="text-center">Record</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($peserta)
                                @php $no = 1 @endphp
                                @foreach($peserta as $pst)
                                <tr>
                                    <td class="text-center">{{ $no }}</td>
                                    <td>
                                        <label class="fancy-checkbox checkPst">
                                            <input type="checkbox" name="code_rec[]" class="val_pst" value="{{ $pst->kode_peserta }}" {{ (is_array(old('code_rec')) && in_array($pst->kode_peserta, old('code_rec'))) ? ' checked' : '' }}>
                                            <span class="size_name">&ensp;{{ $pst->nama_peserta }}</span>
                                        </label>
                                    </td>
                                    <td class="text-left">{{ 'Kyu '. $pst->tingkat .' / '. get_belt_by_kyu($pst->tingkat) }}</td>
                                    <td class="text-center">{{ getPercentTrainPstByClassAndCode($kelas, $pst->kode_peserta) }} @if(getPercentTrainPstByClassAndCode($kelas, $pst->kode_peserta) > 0) %@endif</td>
                                    <td class="text-center"><a href="{{ route('kelas.record.latihan').'?key='.$kelas.'&pst='.$pst->kode_peserta }}" class="btn btn-sm btn-primary" type="button"><i class="fas fa-clipboard fa-2x"></i></a></td>
                                </tr>
                                @php $no++ @endphp
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="box box-primary" id="panelKetLatihan" hidden>
            <div class="box-body" style="">
                <div class="form-group mb-3 {{ $errors->has('keterangan') ? 'has-error' : '' }}">
                    <label for="validationTextarea">Keterangan Latihan</label>
                    <textarea class="form-control is-invalid" id="validationTextarea" name="keterangan" id="keterangan" placeholder="@if($errors->has('keterangan')){{'Keterangan Latihan Harus Diisi'}}@else{{'Keterangan Latihan'}}@endif" onclick="this.placeholder=''" onblur="this.placeholder='@if($errors->has('keterangan')){{'Keterangan Latihan Harus Diisi'}}@else{{'Keterangan Latihan'}}@endif'"></textarea>
                </div>
                <div class="form-group">
                    <label for="durasi">Durasi Latihan</label><br>
                    <div class="btn-group btn-group-toggle {{ $errors->has('durasi') ? 'has-error' : '' }}" data-toggle="buttons">
                        <label class="btn btn-danger">
                            <input type="radio" name="durasi" value="1" id="opt1" autocomplete="off" required>1 Jam
                        </label>
                        <label class="btn btn-warning active">
                            <input type="radio" name="durasi" value="2" id="opt2" autocomplete="off" required>2 Jam
                        </label>
                        <label class="btn btn-success">
                            <input type="radio" name="durasi" value="3" id="opt3" autocomplete="off" required>3 Jam
                        </label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> &ensp;Simpan</button>
            </div>
        </div>
    </form>
</section>

@include('body.modal_form.lte_modal_based_auth')

@endsection

@section('footer')

<script>
    $(document).ready(function() {
        $('.checkPst').on('click', function() {
            $('#panelKetLatihan').removeAttr("hidden");
        });
    });
</script>

@if(is_array(old('code_rec')))
<script>
    $(document).ready(function() {
        $('#panelKetLatihan').removeAttr("hidden");
    });
</script>
@endif
<!-- iCheck 1.0.1 -->
<script src="{{ online_asset() }}/plugins/iCheck/icheck.min.js"></script>
<script>
    $(document).ready(function() {
        $('input:checkbox').iCheck({
            checkboxClass: 'icheckbox_flat-blue'
        });
    });
</script>

@endsection