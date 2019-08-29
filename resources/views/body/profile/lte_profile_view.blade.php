@extends('layouts.masterlte')

@section('header')
@endsection

@section('content')

<section class="content-header">
    <h1>Profil {{ $bioProfile['name'] }}</h1>
    {!! createBreadcrumbByArrayOfCode(['profile', $bioProfile['code']]) !!}
</section>

<section class="content">
    <div class="row">
        <div class="col-md-3">
            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle" src="{{ getAvatarUserById($bioProfile['id']) }}" alt="User profile picture">
                    <h3 class="profile-username text-center">{{ $bioProfile['name'] }}</h3>
                    <p class="text-muted text-center">{{ getStatusUserById($bioProfile['status']) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <!-- About Me Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">About Me</h3>
                </div>
                <div class="box-body">
                    <i class="fas fa-heartbeat"></i>&ensp;<strong>Born</strong>
                    <p class="text-muted">{{ conv_getDate($bioProfile['born']) }}</p>
                    <i class="fas fa-phone"></i>&ensp;<strong>Phone</strong>
                    <p class="text-muted">{{ $bioProfile['phone'] }}</p>
                    <i class="fab fa-line"></i>&ensp;<strong>Line_ID</strong>
                    <p class="text-muted">{{ $bioProfile['id_line'] }}</p>
                    @if(($bioProfile['status'] == 'bestnimda') || ($bioProfile['status'] == 'moderator') || ($bioProfile['status'] == 'treasurer') || ($bioProfile['status'] == 'instructor'))
                    <i class="fas fa-id-card"></i>&ensp;<strong>MSH</strong>
                    <p class="text-muted">{{ $bioProfile['msh_pelatih'] }}</p>
                    @elseif($bioProfile['status'] == 'participants')
                    <i class="fas fa-id-card"></i>&ensp;<strong>No Induk</strong>
                    <p class="text-muted">{{ $bioProfile['noinduk'] }}</p>
                    @else
                    <!-- no data -->
                    @endif
                    <i class="fas fa-handshake"></i>&ensp;<strong>Bergabung</strong>
                    <p class="text-muted">{{ conv_getDate($bioProfile['created_at']) }}</p>
                </div>
            </div>
            @if($bioProfile['status'] == 'participants')
            <!-- wali peserta -->
            @if(getInfoParentsPesertaByCode($bioProfile['code']) != NULL)
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Wali Peserta</h3>
                </div>
                <div class="box-body">
                    @foreach(getInfoParentsPesertaByCode($bioProfile['code']) as $wali)
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
            @endif

            @if($bioProfile['status'] == 'parents')
            <!-- anak orang tua -->
            @if(getInfoAnakWaliByCode($bioProfile['code']) != NULL)
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Anak</h3>
                </div>
                <div class="box-body">
                    @foreach(getInfoAnakWaliByCode($bioProfile['code']) as $anak)
                    <div class="box box-widget">
                        <div class="user-block" style="padding-bottom: 5px;">
                            <img class="img-circle" src="{{ getAvatarUserById($anak->id) }}">
                            <span class="username"><a href="/profile/account/{{ $anak->slug_name }}">{{ $anak->name }}</a></span>
                            <span class="description">{{ getStatusUserById($anak->status) }}</span>
                        </div>
                        <div class="box-footer">
                            <i class="fas fa-heartbeat"></i>&ensp;<strong>Born</strong>
                            <p class="text-muted">{{ conv_getDate($anak->born) }}</p>
                            <i class="fas fa-phone"></i>&ensp;<strong>Phone</strong>
                            <p class="text-muted">{{ $anak->phone }}</p>
                            <i class="fab fa-line"></i>&ensp;<strong>Line_ID</strong>
                            <p class="text-muted">{{ $anak->id_line }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
            @endif
        </div>
    </div>
</section>

@endsection

@section('footer')
@endsection