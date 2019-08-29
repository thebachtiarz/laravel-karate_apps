@extends('layouts.masterlte')

@section('header')
@endsection

@section('content')

<section class="content-header">
    <h1>Profil {{ $data['name'] }}</h1>
    {!! createBreadcrumbByArrayOfCode(['profile', $data['code']]) !!}
</section>

<section class="content">
    <div class="row">
        <div class="col-md-3">
            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle" src="{{ getAvatarUserById($data['id']) }}" alt="User profile picture">
                    <h3 class="profile-username text-center">{{ $data['name'] }}</h3>
                    <p class="text-muted text-center">{{ getStatusUserById($data['status']) }}</p>
                </div>
            </div>

            <!-- About Me Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">About User</h3>
                </div>
                <div class="box-body">
                    <i class="fas fa-heartbeat"></i>&ensp;<strong>Born</strong>
                    <p class="text-muted">{{ conv_getDate($data['born']) }}</p>
                    <i class="fas fa-phone"></i>&ensp;<strong>Phone</strong>
                    <p class="text-muted">{{ $data['phone'] }}</p>
                    <i class="fab fa-line"></i>&ensp;<strong>Line_ID</strong>
                    <p class="text-muted">{{ $data['id_line'] }}</p>
                    @if($data['status'] == 'participants')
                    <i class="fas fa-id-card"></i>&ensp;<strong>No Induk</strong>
                    <p class="text-muted">{{ $data['noinduk'] }}</p>
                    @else
                    <!-- null info -->
                    @endif
                    <i class="fas fa-handshake"></i>&ensp;<strong>Bergabung</strong>
                    <p class="text-muted">{{ conv_getDate($data['created_at']) }}</p>
                </div>
            </div>
            @if(getInfoParentsPesertaByCode($data['code']) != NULL)
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Wali Peserta</h3>
                </div>
                <div class="box-body">
                    @foreach(getInfoParentsPesertaByCode($data['code']) as $wali)
                    <div class="box box-widget">
                        <div class="user-block" style="padding-bottom: 5px;">
                            <img class="img-circle" src="{{ getAvatarUserById($wali->id) }}">
                            <span class="username"><a href="/profile/account/{{ $wali->slug_name }}">{{ $wali->name }}</a></span>
                            <span class="description">{{ getStatusUserById($wali->status) }}</span>
                        </div>
                        <div class="box-footer">
                            <i class="fas fa-heartbeat"></i>&ensp;<strong>Born</strong>
                            <p class="text-muted">{{ conv_getDate($wali->born) }}</p>
                            <i class="fas fa-phone"></i>&ensp;<strong>Phone</strong>
                            <p class="text-muted">{{ $wali->phone }}</p>
                            <i class="fab fa-line"></i>&ensp;<strong>Line_ID</strong>
                            <p class="text-muted">{{ $wali->id_line }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class=""><a href="#activity" data-toggle="tab" aria-expanded="false">Activity</a></li>
                    <li class="active"><a href="#timeline" data-toggle="tab" aria-expanded="true">Timeline</a></li>
                    <li class=""><a href="#settings" data-toggle="tab" aria-expanded="false">Settings</a></li>
                    <li class=""><a href="#persyaratan" data-toggle="tab" aria-expanded="false">Persyaratan</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane" id="activity">

                    </div>
                    <div class="tab-pane active" id="timeline">

                    </div>
                    <div class="tab-pane" id="settings">
                        <p>Tambahkan metode untuk melakukan perubahan terhadap tingkat peserta setelah peserta dinyatakan naik setelah ujian dilaksanakan</p>
                    </div>
                    <div class="tab-pane" id="persyaratan">
                        <div style="padding-bottom: 5px;">
                            @if(get_lastSaldoUser_by_code($data['kode_kelas_peserta'], $data['code']) > 0)
                            <form action="/pengaturan/persyaratan/budget/refunds_all" method="post" accept-charset="ISO-8859-1">
                                @csrf
                                <input type="hidden" name="class_code" value="{{ $data['kode_kelas_peserta'] }}" readonly>
                                <input type="hidden" name="kode_peserta" value="{{ $data['code'] }}" readonly>
                                <button type="submit" class="btn btn-primary returnCashPeserta" style="font-weight: bold;" data-saldo="{{ mycurrency(get_lastSaldoUser_by_code($data['kode_kelas_peserta'], $data['code'])) }}"><i class="fas fa-exchange-alt"></i>&ensp;KEMBALIKAN SEMUA DANA</button>
                            </form>
                            @endif
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover table-condensed">
                                <thead class="bg-primary">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Waktu</th>
                                        <th class="text-center">Kredit</th>
                                        <th class="text-center">Keterangan</th>
                                        <th class="text-center">Saldo</th>
                                        <th class="text-center">Penanggung Jawab</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {!! getSaldoBalancePstByClassAndCode($data['kode_kelas_peserta'], $data['code']) !!}
                                </tbody>
                            </table>
                        </div>
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover table-condensed">
                                <thead class="bg-primary">
                                    <tr>
                                        <th class="text-center">Jenis</th>
                                        <th class="text-center">Diserahkan</th>
                                        <th class="text-center">Keterangan</th>
                                        <th class="text-center">Penanggung Jawab</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {!! getRecFileExamnPstByClassAndCode($data['kode_kelas_peserta'], $data['code']) !!}
                                </tbody>
                            </table>
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