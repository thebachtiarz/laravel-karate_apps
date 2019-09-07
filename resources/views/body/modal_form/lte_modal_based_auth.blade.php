@if(auth()->user()->status == 'moderator')
@if((Request::segment(1) == 'kelas') && (Request::segment(2) != 'record'))
<!-- Modal Add Class -->
<div class="modal fade" id="add_kelas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="/kelas" method="POST" class="was-validated" enctype="multipart/form-data" accept-charset="ISO-8859-1">
                @csrf
                <div class="modal-header alert-info">
                    <h3 class="modal-title" id="exampleModalLabel">Tambah Kelas</h3>
                </div>
                <div class="modal-body">
                    <div class="form-group {{ $errors->has('nama_kelas') ? 'has-error' : '' }}">
                        <label for="nama_kelas">Nama Kelas</label>
                        <input type="text" class="form-control" id="nama_kelas" name="nama_kelas" placeholder="@if($errors->has('nama_kelas')){{ $errors->first('nama_kelas') }}@else{{ 'Nama Kelas' }}@endif" value="{{ old('nama_kelas') }}" onclick="this.placeholder=''" onblur="this.placeholder='@if($errors->has('nama_kelas')){{ $errors->first('nama_kelas') }}@else{{ 'Nama Kelas' }}@endif'">
                    </div>
                    <div class="form-group {{ $errors->has('durasi_latihan') ? 'has-error' : '' }}">
                        <label for="durasi_latihan">Durasi Latihan</label>
                        <select class="form-control" id="durasi_latihan" name="durasi_latihan">
                            <option value="" disabled selected hidden>@if($errors->has('durasi_latihan')){{ $errors->first('durasi_latihan') }}@else{{ 'Durasi Latihan' }}@endif</option>
                            <option value="96" {{ (old('durasi_latihan') == '96') ? 'selected' : '' }}>Full (96 jam = 6 bln) (Recomended)</option>
                            <option value="72" {{ (old('durasi_latihan') == '72') ? 'selected' : '' }}>72 Jam (2 Jam x 36 Hari)</option>
                            <option value="48" {{ (old('durasi_latihan') == '48') ? 'selected' : '' }}>48 Jam (2 Jam x 24 Hari)</option>
                            <option value="36" {{ (old('durasi_latihan') == '36') ? 'selected' : '' }}>36 Jam (2 Jam x 18 Hari)</option>
                            <option value="24" {{ (old('durasi_latihan') == '24') ? 'selected' : '' }}>24 Jam (2 Jam x 12 Hari)</option>
                        </select>
                    </div>
                    <label for="lfm">Gambar Kelas (jika ada)</label><br>
                    <div class="input-group {{ $errors->has('avatar') ? 'has-error' : '' }}">
                        <span class="input-group-btn">
                            <a id="lfm" data-input="avatar" data-preview="holder" class="btn btn-primary">
                                <i class="fa fa-picture-o"></i> Choose
                            </a>
                        </span>
                        <input id="avatar" class="form-control" type="text" name="avatar">
                        @if($errors->has('avatar'))<span class="help-block">{{ $errors->first('avatar') }}</span>@endif
                    </div>
                    <img id="holder" style="margin-top:15px;max-height:100px;">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endif

@if((auth()->user()->status == 'moderator') || (auth()->user()->status == 'treasurer'))
@if(Request::segment(3) == 'persyaratan' && isset($data_peserta))
<!-- Modal Add Data Persyaratan -->
<div class="modal fade" id="add_data" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header alert-info">
                <h3 class="modal-title" id="exampleModalLabel">Tambah Data Persyaratan</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('kelas.record.persyaratan') }}" method="POST" class="was-validated" accept-charset="ISO-8859-1">
                    @csrf<input type="hidden" name="kode_kelas" value="{{ $data_peserta['kode_kelas_peserta'] }}" readonly><input type="hidden" name="kode_peserta" value="{{ $data_peserta['kode_peserta'] }}" readonly>
                    <div class="row mx-1">
                        <div class="col-sm-12">
                            <h4>Persyaratan Biaya Ujian</h4>
                        </div>
                    </div>
                    <div class="row mx-1 pt-1">
                        <div class="col-sm-12 col-md-4 col-lg-3">Kredit</div>
                        <div class="col-sm-12 col-md-8 col-lg-9">
                            @if(getCostExamnPstByClassAndCode($data_peserta['kode_kelas_peserta'], $data_peserta['kode_peserta']))
                            @if(get_lastSaldoUser_by_code($data_peserta['kode_kelas_peserta'], $data_peserta['kode_peserta']) < getCostExamnPstByClassAndCode($data_peserta['kode_kelas_peserta'], $data_peserta['kode_peserta'])) <div class="form-group {{ $errors->has('kredit') ? 'has-error' : '' }}">
                                <input type="text" inputmode="numeric" class="form-control is-invalid" id="rupiah" placeholder="@if($errors->has('kredit')){{ 'Nominal Jumlah Kredit Salah' }}@else{{ 'Jumlah Kredit' }}@endif" minlength="5" maxlength="13" onclick="this.placeholder=''" onblur="this.placeholder='@if($errors->has('kredit')){{ 'Nominal Jumlah Kredit Salah' }}@else{{ 'Jumlah Kredit' }}@endif'">
                                <input type="hidden" inputmode="text" class="form-control" id="creditpst" name="kredit" value="" minlength="4" maxlength="6" readonly>
                                {!! getKeteranganPaymentExamnByCodeAndClass($data_peserta['kode_kelas_peserta'], $data_peserta['kode_peserta']) !!}
                        </div>
                        @else
                        <h4 class="text-primary text-bold">Pembayaran Sudah Lunas!</h4>
                        @endif
                        @else
                        <h4 class="text-warning text-bold">Biaya Ujian Belum Ditentukan!</h4>
                        @endif
                    </div>
            </div>
            <div class="row mx-1 pt-3">
                <div class="col-sm-12 btn-modal"><button type="submit" class="btn btn-primary" name="type" value="budget"><i class="fas fa-credit-card"></i>&ensp;Proses</button></div>
            </div>
            </form>
            <hr class="mx-1">
            <form action="{{ route('kelas.record.persyaratan') }}" method="POST" class="was-validated" accept-charset="ISO-8859-1">
                @csrf<input type="hidden" name="kode_kelas" value="{{ $data_peserta['kode_kelas_peserta'] }}" readonly><input type="hidden" name="kode_peserta" value="{{ $data_peserta['kode_peserta'] }}" readonly>
                <div class="row mx-1">
                    <div class="col-sm-12">
                        <h4>Persyaratan File Dokumen</h4>
                    </div>
                </div>
                <div class="row mx-1 pt-1">
                    <div class="col-sm-12 col-md-4 col-lg-3"><label for="kode_file">Jenis</label></div>
                    <div class="col-sm-12 col-md-8 col-lg-9">
                        <div class="form-group {{ $errors->has('kode_file') ? 'has-error' : '' }}">
                            <select class="form-control" id="kode_file" name="kode_file">
                                <option value="" disabled selected hidden>@if($errors->has('kode_file')){{ 'Jenis Persyaratan Harus Ada' }}@else{{ 'Jenis Persyaratan' }}@endif</option>
                                {!! getExamnFileReqHaveNotBeenCollectedByCodePst($data_peserta['kode_kelas_peserta'], $data_peserta['kode_peserta'], old('kode_file')) !!}
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mx-1 pt-1">
                    <div class="col-sm-12 col-md-4 col-lg-3"><label for="file_info">Keterangan</label></div>
                    <div class="col-sm-12 col-md-8 col-lg-9">
                        <div class="form-group {{ $errors->has('file_info') ? 'has-error' : '' }}">
                            <input type="text" class="form-control is-invalid" id="file_info" name="file_info" placeholder="@if($errors->has('file_info')){{ 'Masukkan Keterangan Kelengkapan' }}@else{{ 'Keterangan kelengkapan' }}@endif" onclick="this.placeholder=''" onblur="this.placeholder='@if($errors->has('file_info')){{ 'Masukkan Keterangan Kelengkapan' }}@else{{ 'Keterangan kelengkapan' }}@endif'">
                        </div>
                    </div>
                </div>
                <div class="row mx-1 pt-3">
                    <div class="col-sm-12"><button type="submit" class="btn btn-primary" name="type" value="file"><i class="fas fa-archive"></i>&ensp;Simpan</button></div>
                </div>
            </form>
        </div>
        <div class="modal-footer alert-info">
        </div>
    </div>
</div>
</div>
@endif
@endif

@if((auth()->user()->status == 'moderator') || (auth()->user()->status == 'treasurer') || (auth()->user()->status == 'instructor'))
@if((Request::segment(2) == 'record' && isset($kelas)) || ((Request::segment(1) == 'pengaturan' && Request::segment(2) == 'class') && isset($data_kelas['kode_kelas'])))
<!-- Modal Add Peserta -->
<div class="modal fade" id="add_peserta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="/kelas/add_peserta" method="POST" class="was-validated" accept-charset="ISO-8859-1">
                @csrf
                <input type="hidden" name="kode_kelas" value="{{ (isset($kelas)) ? $kelas : $data_kelas['kode_kelas'] }}" readonly>
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
@endif
@endif