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
                    <i class="fas fa-at"></i>&ensp;<strong>Email</strong>
                    <p class="text-muted">{{ $data['email'] }}</p>
                    @if(($data['status'] == 'bestnimda') || ($data['status'] == 'moderator') || ($data['status'] == 'treasurer') || ($data['status'] == 'instructor'))
                    <i class="fas fa-id-card"></i>&ensp;<strong>MSH</strong>
                    <p class="text-muted">{{ $data['msh_pelatih'] }}</p>
                    @elseif($data['status'] == 'participants')
                    <i class="fas fa-id-card"></i>&ensp;<strong>No Induk</strong>
                    <p class="text-muted">{{ $data['noinduk'] }}</p>
                    @else
                    <!-- null info -->
                    @endif
                    <i class="fas fa-handshake"></i>&ensp;<strong>Bergabung</strong>
                    <p class="text-muted">{{ conv_getDate($data['created_at']) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class=""><a href="#activity" data-toggle="tab" aria-expanded="false">Activity</a></li>
                    <li class="active"><a href="#timeline" data-toggle="tab" aria-expanded="true">Timeline</a></li>
                    <li class=""><a href="#settings" data-toggle="tab" aria-expanded="false">Settings</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane" id="activity">

                    </div>
                    <div class="tab-pane active" id="timeline">

                    </div>
                    <div class="tab-pane" id="settings">
                        @if(convStatUserToIndex($data['status']) != '6')
                        <form action="/setting/apps/users/{{ $data['id'] }}/edit" method="POST">
                            @csrf
                            <input type="hidden" name="type" value="updateToModerator" readonly>
                            <input type="hidden" name="name_user" value="{{ $data['name'] }}" readonly>
                            <button type="submit" class="btn @if(convStatUserToIndex($data['status']) <= 1) btn-primary @else btn-danger @endif" id="updToMod"><i class="fas fa-upload"></i>&ensp;Jadikan Pengurus Ranting</button>
                        </form>
                        @endif
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
<script src="{{ asset('js/prog_setting_admin.js') }}"></script>
@endsection