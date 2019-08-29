@extends('layouts.master')

@section('header')
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
                                <a type="button" class="btn btn-success" data-toggle="modal" data-target="#add_peserta"><i class="fas fa-plus"></i>&ensp;Tambah Peserta</a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-condensed">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Nama</th>
                                            <th class="text-center">Tingkatan</th>
                                            <th class="text-center">Kelengkapan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($peserta)
                                        @php $no = 1 @endphp
                                        @foreach($peserta as $pst)
                                        <tr>
                                            <td class="text-center">{{ $no }}</td>
                                            <td class="text-left">{{ $pst->nama_peserta }}</td>
                                            <td class="text-left">{{ 'Kyu '. $pst->tingkat .' / '. get_belt_by_kyu($pst->tingkat) }}</td>
                                            <td class="text-center"><a href="{{ route('kelas.record.persyaratan').'?key='.$kelas.'&pst='.$pst->kode_peserta }}" class="btn btn-sm btn-primary" type="button"><i class="fas fa-file-invoice fa-2x"></i></a></td>
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
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="add_peserta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="/kelas/add_peserta" method="POST" class="was-validated" accept-charset="ISO-8859-1">
                @csrf<input type="hidden" name="kode_kelas" value="{{ $kelas }}" readonly>
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
@endsection