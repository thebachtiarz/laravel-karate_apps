@extends('layouts.masterlte')

@section('header')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('content')

<section class="content-header">
    <h1>Otentifikasi</h1>
    {!! createBreadcrumbByArrayOfCode(['otentifikasi']) !!}
</section>

<section class="content">
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-primary">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="searchResult">Cari...</label>
                                <input type="text" class="form-control" id="searchResult" data-need="otentifikasi" data-goto="colResult" placeholder="Cari nama pelatih atau nama kelas" onclick="this.placeholder=''" onblur="this.placeholder='Cari nama pelatih atau nama kelas'">
                            </div>
                            <div id="inputResult" hidden>
                                <form action="" method="post" accept-charset="ISO-8859-1">
                                    @csrf
                                    <div class="form-group">
                                        <label for="nama_pelatih">Nama Pelatih</label>
                                        <input type="text" class="form-control" id="nama_pelatih" name="nama_pelatih" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_kelas">Kelas</label>
                                        <input type="text" class="form-control" id="nama_kelas" name="nama_kelas" required readonly>
                                    </div>
                                    <div class="form-group {{ $errors->has('new_stat') ? 'has-error' : '' }}">
                                        <label for="nama_kelas">Tipe Akun</label>
                                        <select class="form-control" id="new_stat" name="new_stat" required>
                                            <option value="" disabled selected hidden>Pilih Tipe Akun</option>
                                            <option value="3" {{ (old('new_stat') == '3') ? 'selected' : '' }}>Peserta Latihan</option>
                                            <option value="2" {{ (old('new_stat') == '2') ? 'selected' : '' }}>Orang Tua Peserta</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="pesan">Pesan</label>
                                        <textarea class="form-control" name="pesan" id="pesan"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary saveButton">Kirim Permintaan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div id="colResult" hidden>
                                <label>Hasil...</label>
                                <div id="valueResult"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(json_decode($reqOtt) != NULL)
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-success">
                <div class="box-header">
                    <h3 class="box-title">Permintaan Otentifikasi</h3><br>
                    <small style="color: gray;">Harap menunggu konfirmasi dari pelatih</small>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-borderless table-light table-hover table-condensed">
                            <thead class="bg-primary">
                                <tr>
                                    <th>#</th>
                                    <th>Nama Pelatih</th>
                                    <th>Nama Kelas</th>
                                    <th>Tipe Permintaan</th>
                                    <th>Waktu</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $rno = 1 @endphp
                                @foreach($reqOtt as $rtt)
                                <tr>
                                    <td>{{ $rno++ }}</td>
                                    <td>{{ getNamePltByCode($rtt->tujuan_code) }}</td>
                                    <td>{{ getClassNameByCode($rtt->tujuan_kelas) }}</td>
                                    <td>{{ getStatusUserById(convStatUserToStatName($rtt->asal_newstat)) }}</td>
                                    <td>{{ conv_getDate($rtt->created_at) }}</td>
                                    <td>Menunggu</td>
                                    <td><a href="/otentifikasi/hapus/{{ $rtt->id }}" class="btn btn-sm btn-danger delete-req" data-type="Permintaan Otentifikasi">Hapus</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</section>

@endsection

@section('footer')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8.13.0/dist/sweetalert2.all.min.js" integrity="sha256-aakU0ciz46DahtBruJmV8isJWXw6TELTYFPcSVVcoFU=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.js"></script>
<script src="{{ asset('js/guests_otentifikasi.js') }}"></script>
@endsection