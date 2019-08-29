@extends('layouts.master')

@section('header')
<style>
    .size_name {
        font-size: 100% !important;
    }
</style>
@endsection

@section('content')
<div class="main">
    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="container-fluid">
            {{ createBreadcrumbByArrayOfCode(['kelas', $kelas]) }}
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="right">
                                <a type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_peserta"><i class="fas fa-plus"></i>&ensp;Tambah Peserta</a>
                            </div>
                        </div>
                        <form class="was-validated" action="/kelas/record/latihan" method="post" accept-charset="ISO-8859-1">
                            @csrf<input type="hidden" name="class_code" value="{{ $kelas }}" readonly>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-condensed">
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
                                                    <label class="fancy-checkbox">
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
                            <div class="panel-body" id="panelKetLatihan" hidden>
                                <div class="container-fluid">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="add_peserta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="/kelas/add_peserta" method="POST" class="was-validated" accept-charset="ISO-8859-1">
                @csrf
                <input type="hidden" name="kode_kelas" value="{{ $kelas }}" readonly>
                <div class="modal-header alert-info">
                    <h3 class="modal-title" id="exampleModalLabel">Tambah Peserta</h3>
                </div>
                <div class="modal-body">
                    <div class="form-group {{ $errors->has('nama_peserta') ? 'has-error' : '' }}">
                        <label for="nama_peserta">Nama Peserta</label>
                        <input type="text" class="form-control" id="nama_peserta" name="nama_peserta" placeholder="@if($errors->has('nama_peserta')){{ $errors->first('nama_peserta') }}@else{{ 'Nama Peserta' }}@endif" value="{{ old('nama_peserta') }}" onclick="this.placeholder=''" onblur="this.placeholder='@if($errors->has('nama_peserta')){{ $errors->first('nama_peserta') }}@else{{ 'Nama Peserta' }}@endif'">
                    </div>
                    <div class="form-group {{ $errors->has('tingkat') ? 'has-error' : '' }}">
                        <label for="tingkat">Tingkat / Kyu</label>
                        <select class="form-control" id="tingkat" name="tingkat">
                            <option value="" disabled selected hidden>@if($errors->has('tingkat')){{ $errors->first('tingkat') }}@else{{ 'Tingkat' }}@endif</option>
                            @for ($i = 10; $i >= 1; $i--)<option value="{{ $i }}" {{ (old('tingkat') == $i) ? 'selected' : '' }}>Kyu {{ $i }} / {{ get_belt_by_kyu($i) }}</option>@endfor
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="noinduk">Nomor Induk Anggota</label>
                        <input type="text" class="form-control" id="noinduk" name="noinduk" placeholder="Nomor Induk" value="{{ old('noinduk') }}" onclick="this.placeholder=''" onblur="this.placeholder='Nomor Induk'">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('footer')
<script>
    $('.val_pst').on('change', function(e) {
        if (e.target.checked) {
            $('#panelKetLatihan').removeAttr("hidden");
        }
    });
</script>
@if(is_array(old('code_rec')))
<script>
    $('#panelKetLatihan').removeAttr("hidden");
</script>
@endif

@endsection