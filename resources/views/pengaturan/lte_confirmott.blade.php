@extends('layouts.masterlte')

@section('header')
@endsection

@section('content')

<section class="content-header">
    <h1>Konfirmasi Otentifikasi</h1>
    {!! createBreadcrumbByArrayOfCode(['pengaturan', $data['tujuan_kelas']]) !!}
</section>

<section class="content">
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-primary">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="table-responsive">
                                <table class="table table-borderless table-light table-hover table-condensed">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Tipe</th>
                                            <th>Pesan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ getPstNameByEmail($data['asal_email']) }}</td>
                                            <td>{{ $data['asal_email'] }}</td>
                                            <td>{{ getStatusUserById(convStatUserToStatName($data['asal_newstat'])) }}</td>
                                            <td>{{ $data['asal_info'] }}</td>
                                            <td><button class="btn btn-sm btn-primary searchPeserta" data-need="pesertakelas" data-kelas="{{ $data['tujuan_kelas'] }}" value="{{ getPstNameByEmail($data['asal_email']) }}">Cari</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control searchPeserta" data-need="pesertakelas" data-kelas="{{ $data['tujuan_kelas'] }}" placeholder="Cari nama peserta pada kelas ini secara manual" onclick="this.placeholder=''" onblur="this.placeholder='Cari nama peserta pada kelas ini secara manual'">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div id="resultPesertaKelas"></div>
                            <div id="getSelectedPeserta" hidden>
                                <form action="" method="post" accept-charset="ISO-8859-1">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nama_pemohon">Nama Pemohon</label>
                                                <input type="text" class="form-control" id="nama_pemohon" name="nama_pemohon" value="{{ getPstNameByEmail($data['asal_email']) }}" required readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nama_ditemukan">Nama Ditemukan</label>
                                                <input type="text" class="form-control" id="nama_ditemukan" name="nama_ditemukan" required readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email_pemohon">Email Pemohon</label>
                                                <input type="text" class="form-control" id="email_pemohon" name="email_pemohon" value="{{ $data['asal_email'] }}" required readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="code_ditemukan">Code Ditemukan</label>
                                                <input type="text" class="form-control" id="code_ditemukan" name="code_ditemukan" required readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary saveButton" data-type="Otentifikasi">Konfirmasi Otentifikasi</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('footer')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8.13.0/dist/sweetalert2.all.min.js" integrity="sha256-aakU0ciz46DahtBruJmV8isJWXw6TELTYFPcSVVcoFU=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.js"></script>
<script src="{{ asset('js/moderator_pengaturan.js') }}"></script>
@endsection