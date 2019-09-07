@extends('layouts.masterlte')

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
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('content')

<section class="content-header">
    <h1>Pengaturan</h1>
    {!! createBreadcrumbByArrayOfCode(['pengaturan', $data_kelas['kode_kelas']]) !!}
</section>

<section class="content">
    <div class="row">
        <div class="col-md-5">
            <div class="box box-primary">
                <img src="{{ getKelasAvatar($data_kelas['kode_kelas']) }}" class="ImgResponsive">
            </div>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Info Kelas</h3>
                </div>
                <div class="box-body">
                    <i class="fas fa-building"></i>&ensp;<strong>Nama Kelas</strong>
                    <p class="text-muted">{{ $data_kelas['nama_kelas'] }}</p>
                    <i class="fas fa-user-secret"></i>&ensp;<strong>Pemilik</strong>
                    <p class="text-muted">{{ getNamePltByCode($data_kelas['kode_pelatih']) }}</p>
                    <i class="fas fa-clock"></i>&ensp;<strong>Didirikan</strong>
                    <p class="text-muted">{{ conv_getDate($data_kelas['created_at']) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#classresident" data-toggle="tab" aria-expanded="true">Warga Kelas</a></li>
                    <li class=""><a href="#editkelas" data-toggle="tab" aria-expanded="false">Edit Kelas</a></li>
                    <li class=""><a href="#syaratujian" data-toggle="tab" aria-expanded="false">Persyaratan Ujian</a></li>
                    <li class=""><a href="#spp" data-toggle="tab" aria-expanded="false">SPP Kelas</a></li>
                    <li class=""><a href="#thsmt" data-toggle="tab" aria-expanded="false" {!! (getThnSmtClassByCode($data_kelas['kode_kelas']) !=getThSmtNow()) ? 'id="blinkIt"' : '' !!}>Tahun Semester {!! (getThnSmtClassByCode($data_kelas['kode_kelas']) != getThSmtNow()) ? '<i class="fas fa-exclamation-circle" style="color: #f96;"></i>' : '' !!}</a></li>
                </ul>

                <div class=" tab-content">
                    <div class="tab-pane active" id="classresident">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="small-box bg-aqua">
                                    <div class="inner">
                                        <h3>{{ getCountPesertaByClassCode($data_kelas['kode_kelas']) }}</h3>
                                        <p>Peserta</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <a href="" class="small-box-footer GridButton showToggle page-scroll" id="dataPesertaToggle" data-goto="dataPeserta" data-need="getdatapeserta" data-kodekelas="{{ $data_kelas['kode_kelas'] }}" data-send="thisDataPeserta" onclick="return false;"><i class="fas fa-tasks"></i>&ensp;Kelola Peserta</a>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="small-box bg-aqua">
                                    <div class="inner">
                                        <h3>{{ getCountPelatihByClass($data_kelas['kode_kelas']) }}</h3>
                                        <p>Pelatih</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-chalkboard-teacher"></i>
                                    </div>
                                    <a href="" class="small-box-footer GridButton showToggle page-scroll" id="addPelatihToggle" data-goto="addPelatih" data-need="getdatapelatih" data-kodekelas="{{ $data_kelas['kode_kelas'] }}" data-send="thisDataPelatih" onclick="return false;"><i class="fas fa-tasks"></i>&ensp;Kelola Pelatih</a>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="small-box bg-aqua">
                                    <div class="inner">
                                        <h3>{{ getCountBendaharaByClass($data_kelas['kode_kelas']) }}</h3>
                                        <p>Bendahara</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-wallet"></i>
                                    </div>
                                    <a href="" class="small-box-footer GridButton showToggle page-scroll" id="addBendaharaToggle" data-goto="addBendahara" data-need="getdatabendahara" data-kodekelas="{{ $data_kelas['kode_kelas'] }}" data-send="thisDataBendahara" onclick="return false;"><i class="fas fa-tasks"></i>&ensp;Kelola Bendahara</a>
                                </div>
                            </div>
                        </div>
                        <section class="dataPeserta addHiddenToggle" id="dataPeserta" style="margin-top:15px;" hidden>
                            <div class="nav-tabs-custom tab-inverse">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#peserta_kelas" data-toggle="tab">Peserta</a></li>
                                    <li><a href="#peserta_tingkat" data-toggle="tab">Tingkat</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="peserta_kelas">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <button class="btn btn-primary GridButton" data-toggle="modal" data-target="#add_peserta"><i class="fas fa-plus"></i>&ensp;Tambah Peserta</button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <!-- data ajax here -->
                                            <div class="col-sm-12" id="thisDataPeserta"></div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="peserta_tingkat">
                                        <div class="row">
                                            <!-- data ajax here -->
                                            <div class="col-sm-12" id="thisDataTingkatPeserta"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12" id="newFormRaporPeserta">
                                                <h3>Form Rapor</h3>
                                                <p>Pengurus Ranting dapat menambahkan data rapor peserta ketika peserta dinyatakan naik kyu setelah ujian</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <section class="addPelatih addHiddenToggle" id="addPelatih" style="margin-top:15px;" hidden>
                            <div class="row">
                                <form action="" method="POST" class="was-validated" accept-charset="ISO-8859-1">
                                    @csrf <input type="hidden" name="type" value="addPelatih" readonly>
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            <input type="email" class="form-control" id="getNamaPelatih" name="pelatih_baru" data-ajaxjson="newpelatih" placeholder="Tambah Pelatih (Masukkan Nama)" onclick="this.placeholder=''" onblur="this.placeholder='Tambah Pelatih (Masukkan Nama)'" required>
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
                    <div class="tab-pane" id="editkelas">
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
                    <div class="tab-pane" id="syaratujian">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="nav-tabs-custom">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a href="#biayaUjian" role="tab" data-toggle="tab" aria-expanded="true">Biaya Ujian</a></li>
                                        <li class=""><a href="#fileUjian" role="tab" data-toggle="tab" aria-expanded="false">Berkas Ujian</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="biayaUjian">
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
                                        <div class="tab-pane" id="fileUjian">
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
                        </div>
                    </div>
                    <div class="tab-pane" id="spp">
                        <form action="" method="POST" class="was-validated" accept-charset="ISO-8859-1">
                            @csrf <input type="hidden" name="type" value="sppkelas" readonly>
                            <div class="form-group">
                                <label for="this_spp_kelas">Biaya SPP</label>
                                <input type="text" inputmode="numeric" class="form-control sppKelas" id="this_spp_kelas" placeholder="Tetapkan Biaya SPP" minlength="5" maxlength="13" onclick="this.placeholder=''" onblur="this.placeholder='Tetapkan Biaya SPP'" data-goto="spp_kelas" value="{{ $data_kelas['spp'] }}">
                                <input type="hidden" class="form-control" id="spp_kelas" name="spp_kelas" value="{{ $data_kelas['spp'] }}" minlength="4" maxlength="6" readonly>
                            </div>
                            <input type="hidden" name="kode_kelas" value="{{ $data_kelas['kode_kelas'] }}" readonly>
                            <button type="submit" class="btn btn-primary saveButton" data-type="Biaya SPP"><i class="fas fa-save"></i>&ensp;Simpan Perubahan</button>
                        </form>
                    </div>
                    <div class="tab-pane" id="thsmt">
                        @php
                        if(getThnSmtClassByCode($data_kelas['kode_kelas']) == getThSmtNow()){
                        $infoThsmt = ['info', 'Tahun Semester menunjukkan waktu tahun ajaran kelas saat ini. Mengganti Tahun Semester akan berpengaruh pada hasil penyimpanan data saat melakukan record.'];
                        }
                        else{
                        $infoThsmt = ['warning', 'Tahun Semester pada kelas ini perlu dilakukan pembaruan, Karate Apps menyarankan untuk mengganti ke ' . createThSmtInfoPeserta(getThSmtNow())];
                        }
                        @endphp
                        <div class="alert alert-{{ $infoThsmt[0] }}">
                            <h4><i class="fas fa-info-circle"></i> Info!</h4>
                            <p class="text-black" style="font-style: italic; font-weight: bold;">{{ $infoThsmt[1] }}</p>
                        </div>
                        <form action="" method="POST" class="was-validated" accept-charset="ISO-8859-1">
                            @csrf <input type="hidden" name="type" value="thsmtkelas" readonly>
                            <div class="form-group">
                                <label for="thsmtkelas">Ganti Tahun Semester</label>
                                <select name="thsmt_kelas" class="form-control" id="thsmtkelas">
                                    {{ createOptionSemesterForSearch(getThnSmtClassByCode($data_kelas['kode_kelas'])) }}
                                </select>
                            </div>
                            <input type="hidden" name="kode_kelas" value="{{ $data_kelas['kode_kelas'] }}" readonly>
                            <button type="submit" class="btn btn-primary saveButton" data-type="Tahun Semester"><i class="fas fa-save"></i>&ensp;Simpan Perubahan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('body.modal_form.lte_modal_based_auth')

@endsection

@section('footer')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8.13.0/dist/sweetalert2.all.min.js" integrity="sha256-aakU0ciz46DahtBruJmV8isJWXw6TELTYFPcSVVcoFU=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
<script src="{{ asset('js/moderator_pengaturan.js') }}"></script>
<script src="/vendor/laravel-filemanager/js/lfm.js"></script>
<script>
    $(document).ready(function() {
        $('#lfm').filemanager('image');
    });
</script>
<script>
    $('.biayaUjian, .sppKelas').on('keyup', function() {
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
    $(".biayaUjian, .sppKelas").keyup(function() {
        let goto = $(this).data('goto');
        var kalimat = $(this).val();
        var ganti = kalimat.replace(/[.*+?^${}()|[\]\\]/g, '');
        var res = ganti.slice(3, 10);
        $('input#' + goto).val(res);
    });
</script>
<script>
    $(function() {
        $("#blinkIt").delay(0).animate({
            "background-color": "#f96"
        }, 0, function() {
            $("#blinkIt").animate({
                "background-color": "#fff"
            }, 5000);
        });
    });
</script>
@endsection