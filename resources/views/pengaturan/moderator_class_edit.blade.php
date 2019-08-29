@extends('layouts.master')

@section('header')
<style>
    .ImgResponsive {
        width: 100%;
        height: auto;
    }

    .GridButton {
        margin-bottom: 10px;
    }

    .b-secondary {
        background: #E2E3E5;
    }

    .saveButton {
        margin-top: 10px;
        margin-left: -4px;
    }
</style>
@endsection

@section('content')
<div class="main">
    <div class="main-content">
        <div class="container-fluid">
            <div class="panel panel-profile">
                <div class="clearfix">
                    <div class="profile-left">
                        <div class="profile-header">
                            <div class="overlay"></div>
                            <img src="{{ getKelasAvatar($data_kelas['kode_kelas']) }}" class="ImgResponsive">
                        </div>
                        <div class="profile-detail">
                            <div class="profile-info">
                                <h4 class="heading">Info Kelas</h4>
                                <ul class="list-unstyled list-justify">
                                    <li>Nama Kelas <span>{{ getClassNameByCode($data_kelas['kode_kelas']) }}</span></li>
                                    <li>Pemilik <span>{{ getNamePltByCode($data_kelas['kode_pelatih']) }}</span></li>
                                    <li>Didirikan <span>{{ conv_getDate($data_kelas['created_at']) }}</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="profile-right">
                        <div class="custom-tabs-line tabs-line-bottom left-aligned">
                            <ul class="nav" role="tablist">
                                <li class="active"><a href="#detailKelas" role="tab" data-toggle="tab" aria-expanded="true">Detail Kelas</a></li>
                                <li class=""><a href="#editKelas" role="tab" data-toggle="tab" aria-expanded="false">Edit Kelas</a></li>
                                <li class=""><a href="#examnReq" role="tab" data-toggle="tab" aria-expanded="false">Persyaratan Ujian</a></li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane fade active in" id="detailKelas">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="metric">
                                            <span class="icon"><i class="fas fa-users"></i></span>
                                            <p>
                                                <span class="number">{{ getCountPesertaByClassCode($data_kelas['kode_kelas']) }}</span>
                                                <span class="title">Peserta</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="metric">
                                            <span class="icon"><i class="fas fa-chalkboard-teacher"></i></span>
                                            <p>
                                                <span class="number">{{ getCountPelatihByClass($data_kelas['kode_kelas']) }}</span>
                                                <span class="title">Pelatih</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="metric">
                                            <span class="icon"><i class="fas fa-wallet"></i></span>
                                            <p>
                                                <span class="number">{{ getCountBendaharaByClass($data_kelas['kode_kelas']) }}</span>
                                                <span class="title">Bendahara</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <button class="btn btn-primary btn-block GridButton showToggle" id="dataPesertaToggle" data-goto="dataPeserta" data-need="getdatapeserta" data-kodekelas="{{ $data_kelas['kode_kelas'] }}" data-send="thisDataPeserta"><i class="fas fa-tasks"></i>&ensp;Kelola Peserta</button>
                                    </div>
                                    <div class="col-sm-4">
                                        <button class="btn btn-primary btn-block GridButton showToggle" id="addPelatihToggle" data-goto="addPelatih" data-need="getdatapelatih" data-kodekelas="{{ $data_kelas['kode_kelas'] }}" data-send="thisDataPelatih"><i class="fas fa-tasks"></i>&ensp;Kelola Pelatih</button>
                                    </div>
                                    <div class="col-sm-4">
                                        <button class="btn btn-primary btn-block GridButton showToggle" id="addBendaharaToggle" data-goto="addBendahara" data-need="getdatabendahara" data-kodekelas="{{ $data_kelas['kode_kelas'] }}" data-send="thisDataBendahara"><i class="fas fa-tasks"></i>&ensp;Kelola Bendahara</button>
                                    </div>
                                </div>
                                <section class="dataPeserta addHiddenToggle" id="dataPeserta" style="margin-top:15px;" hidden>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <button class="btn btn-primary GridButton" data-toggle="modal" data-target="#add_peserta"><i class="fas fa-plus"></i>&ensp;Tambah Peserta</button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <!-- data ajax here -->
                                        <div class="col-sm-12" id="thisDataPeserta"></div>
                                    </div>
                                </section>
                                <section class="addPelatih addHiddenToggle" id="addPelatih" style="margin-top:15px;" hidden>
                                    <div class="row">
                                        <form action="" method="POST" class="was-validated" accept-charset="ISO-8859-1">
                                            @csrf <input type="hidden" name="type" value="addPelatih" readonly>
                                            <div class="col-sm-8">
                                                <div class="form-group">
                                                    <input type="email" class="form-control" id="getNamaPelatih" name="pelatih_baru" data-ajaxjson="newpelatih" placeholder="Tambah Pelatih (Masukkan Email)" onclick="this.placeholder=''" onblur="this.placeholder='Tambah Pelatih (Masukkan Email)'" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <input type="hidden" name="kode_kelas" value="{{ $data_kelas['kode_kelas'] }}" readonly>
                                                <button type="submit" class="btn btn-primary addNewResource" data-type="Pelatih">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="row">
                                        <!-- data ajax here -->
                                        <div class="col-sm-12" id="getNamaPelatihData"></div>
                                    </div>
                                    <div class="row">
                                        <!-- data ajax here -->
                                        <div class="col-sm-12" id="thisDataPelatih"></div>
                                    </div>
                                </section>
                                <section class="addBendahara addHiddenToggle" id="addBendahara" style="margin-top:15px;" hidden>
                                    <div class="row">
                                        <form action="" method="POST" class="was-validated" accept-charset="ISO-8859-1">
                                            @csrf <input type="hidden" name="type" value="addBendahara" readonly>
                                            <div class="col-sm-8">
                                                <div class="form-group">
                                                    <select class="form-control" name="bendahara_baru" required>
                                                        <option value="" disabled selected hidden>Tambah Bendahara dari pelatih</option>
                                                        {{ getPltInClassWithoutModeratorSelect($data_kelas['kode_kelas']) }}
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <input type="hidden" name="kode_kelas" value="{{ $data_kelas['kode_kelas'] }}" readonly>
                                                <button type="submit" class="btn btn-primary addNewResource" data-type="Bendahara">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="row">
                                        <!-- data ajax here -->
                                        <div class="col-sm-12" id="thisDataBendahara"></div>
                                    </div>
                                </section>
                            </div>
                            <div class="tab-pane fade" id="editKelas">
                                <section class="infoKelas" id="infoKelas">
                                    <form action="" method="POST" accept-charset="ISO-8859-1" class="was-validated">
                                        @csrf <input type="hidden" name="type" value="editKelas" readonly>
                                        <div class="form-group">
                                            <label for="nama_kelas">Nama Kelas</label>
                                            <input type="text" class="form-control" id="nama_kelas" name="nama_kelas" value="{{ $data_kelas['nama_kelas'] }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="durasi_latihan">Durasi Latihan</label>
                                            <select class="form-control" id="durasi_latihan" name="durasi_latihan">
                                                <option value="96" {{ ($data_kelas['durasi_latihan'] == '96') ? 'selected' : '' }}>Full (96 jam = 6 bln) (Recomended)</option>
                                                <option value="72" {{ ($data_kelas['durasi_latihan'] == '72') ? 'selected' : '' }}>72 Jam (2 Jam x 36 Hari)</option>
                                                <option value="48" {{ ($data_kelas['durasi_latihan'] == '48') ? 'selected' : '' }}>48 Jam (2 Jam x 24 Hari)</option>
                                                <option value="36" {{ ($data_kelas['durasi_latihan'] == '36') ? 'selected' : '' }}>36 Jam (2 Jam x 18 Hari)</option>
                                                <option value="24" {{ ($data_kelas['durasi_latihan'] == '24') ? 'selected' : '' }}>24 Jam (2 Jam x 12 Hari)</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="lfm">Gambar Kelas (jika ada)</label><br>
                                            <div class="input-group">
                                                <span class="input-group-btn">
                                                    <a id="lfm" data-input="avatar" data-preview="holder" class="btn btn-primary">
                                                        <i class="fa fa-picture-o"></i> Choose
                                                    </a>
                                                </span>
                                                <input id="avatar" class="form-control" type="text" name="avatar" value="{{ $data_kelas['avatar'] }}">
                                                @if($errors->has('avatar'))<span class="help-block">{{ $errors->first('avatar') }}</span>@endif
                                            </div>
                                            <img id="holder" style="margin-top:15px;max-height:100px;">
                                        </div>
                                        <button type="submit" class="btn btn-primary saveButton" data-type="Kelas"><i class="fas fa-save"></i>&ensp;Simpan</button>
                                    </form>
                                </section>
                            </div>
                            <div class="tab-pane fade" id="examnReq">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="custom-tabs-line tabs-line-bottom left-aligned">
                                            <ul class="nav" role="tablist">
                                                <li class="active"><a href="#biayaUjian" role="tab" data-toggle="tab" aria-expanded="true">Biaya Ujian</a></li>
                                                <li class=""><a href="#fileUjian" role="tab" data-toggle="tab" aria-expanded="false">Berkas Ujian</a></li>
                                            </ul>
                                        </div>
                                        <div class="tab-content">
                                            <div class="tab-pane fade active in" id="biayaUjian">
                                                <form action="" method="POST" class="was-validated" accept-charset="ISO-8859-1">
                                                    @csrf <input type="hidden" name="type" value="biayaujian" readonly>
                                                    @for ($i = 10; $i >= 1; $i--)
                                                    <div class="form-group row">
                                                        <label for="biaya_" class="col-sm-5 col-form-label">Kyu {{ $i }} / {{ get_belt_by_kyu($i) }}</label>
                                                        <div class="col-sm-7">
                                                            <input type="text" inputmode="numeric" class="form-control biayaUjian" id="biaya" placeholder="Biaya Kyu {{ $i }} / {{ get_belt_by_kyu($i) }}" minlength="5" maxlength="13" onclick="this.placeholder=''" onblur="this.placeholder='Biaya Kyu {{ $i }} / {{ get_belt_by_kyu($i) }}'" data-goto="tingkat_{{ $i }}" value="{{ getBiayaUjianByClassAndTingkat($data_kelas['kode_kelas'], $i) }}">
                                                            <input type="hidden" inputmode="text" class="form-control" id="tingkat_{{ $i }}" name="{{ $i }}" value="{{ getBiayaUjianByClassAndTingkat($data_kelas['kode_kelas'], $i) }}" minlength="4" maxlength="6" readonly>
                                                        </div>
                                                    </div>
                                                    @endfor
                                                    <input type="hidden" name="kode_kelas" value="{{ $data_kelas['kode_kelas'] }}" readonly>
                                                    <button type="submit" class="btn btn-primary saveButton" data-type="Biaya Ujian"><i class="fas fa-save"></i>&ensp;Simpan Perubahan</button>
                                                </form>
                                            </div>
                                            <div class="tab-pane fade" id="fileUjian">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <form action="" method="POST" class="was-validated" accept-charset="ISO-8859-1">
                                                            @csrf <input type="hidden" name="type" value="berkasujian" readonly>
                                                            <div class="form-group row">
                                                                <div class="col-sm-7">
                                                                    <input type="text" name="nama_file" class="form-control GridButton" placeholder="Masukkan Jenis Berkas Baru" onclick="this.placeholder=''" onblur="this.placeholder='Masukkan Jenis Berkas Baru'">
                                                                    <input type="hidden" name="kode_kelas" value="{{ $data_kelas['kode_kelas'] }}" readonly>
                                                                </div>
                                                                <div class="col-sm-5">
                                                                    <button type="submit" class="btn btn-primary btn-block GridButton saveButton" data-type="Berkas Ujian" style="margin-top: 0px; margin-left: 0px;"><i class="fas fa-save"></i>&ensp;Tambah Jenis Berkas</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">{!! getFileExamnDataByClassInTable($data_kelas['kode_kelas']) !!}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add Peserta -->
<div class="modal fade" id="add_peserta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="/kelas/add_peserta" method="POST" class="was-validated" accept-charset="ISO-8859-1">
                @csrf <input type="hidden" name="kode_kelas" value="{{ $data_kelas['kode_kelas'] }}" readonly>
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8.13.0/dist/sweetalert2.all.min.js" integrity="sha256-aakU0ciz46DahtBruJmV8isJWXw6TELTYFPcSVVcoFU=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script>
<!-- <script src="https://raw.githubusercontent.com/openexchangerates/accounting.js/master/accounting.js"></script> -->
<script src="{{ asset('js/moderator_pengaturan.js') }}"></script>
<script src="/vendor/laravel-filemanager/js/lfm.js"></script>
<script>
    $(document).ready(function() {
        $('#lfm').filemanager('image');
    });
</script>

<script>
    // console.log(accounting.formatMoney(-500000, "Rp ", 0));
    // $(document).ready(function() {
    //     var rupiah = $('.biayaUjian').val();
    //     // $(this).val(formatRupiah(this.value, "Rp. "));
    // });

    $('.biayaUjian').on('keyup', function() {
        var rupiah = $(this).val();
        $(this).val(formatRupiah(this.value, "Rp. "));
    });

    function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, "").toString(),
            split = number_string.split(","),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);
        if (ribuan) {
            separator = sisa ? "." : "";
            rupiah += separator + ribuan.join(".");
        }
        rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
        return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
    }
</script>

<script>
    $(".biayaUjian").keyup(function() {
        let goto = $(this).data('goto');
        var kalimat = $(this).val();
        var ganti = kalimat.replace(/[.*+?^${}()|[\]\\]/g, '');
        var res = ganti.slice(3, 10);
        $('input#' + goto).val(res);
    });
</script>

@endsection