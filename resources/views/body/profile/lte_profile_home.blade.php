@extends('layouts.masterlte')

@section('header')
@endsection

@section('content')

<section class="content-header">
    <h1>My Profile</h1>
    {!! createBreadcrumbByArrayOfCode(['profile', auth()->user()->code]) !!}
</section>

<section class="content">
    <div class="row">
        <div class="col-md-3">
            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle" src="{{ getUserAvatar() }}" alt="User profile picture">
                    <h3 class="profile-username text-center">{{ $data['name'] }}</h3>
                    <p class="text-muted text-center">{{ getStatusUserById($data['status']) }}</p>
                </div>
            </div>

            <!-- About Me Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">About Me</h3>
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
                    <!-- no data -->
                    @endif
                    <i class="fas fa-handshake"></i>&ensp;<strong>Bergabung</strong>
                    <p class="text-muted">{{ conv_getDate($data['created_at']) }}</p>
                </div>
            </div>
            @if(auth()->user()->status == 'participants')
            <!-- wali peserta -->
            @if(getInfoParentsPesertaByCode($data['code']) != NULL)
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Wali</h3>
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
            @endif

            @if(auth()->user()->status == 'parents')
            <!-- anak orang tua -->
            @if(getInfoAnakWaliByCode($data['code']) != NULL)
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Anak</h3>
                </div>
                <div class="box-body">
                    @foreach(getInfoAnakWaliByCode($data['code']) as $anak)
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
                        <form action="" method="POST" class="form-horizontal was-validated" enctype="multipart/form-data" accept-charset="ISO-8859-1">
                            @csrf <input type="hidden" name="type" value="editbio" readonly>
                            <div class="form-group">
                                <label for="fullname" class="col-sm-2 control-label">Nama Lengkap</label>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <input type="text" class="form-control" id="fullname" name="name" value="{{ $data['name'] }}" placeholder="Nama Lengkap" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="born" class="col-sm-2 control-label">Tanggal Lahir</label>
                                <div class="col-sm-10">
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="date" class="form-control pull-right" id="born" name="born" value="@if($data['born'] != NULL){{ $data['born'] }}@else {{ '2002-01-01' }} @endif" placeholder="Tanggal Lahir">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="phone" class="col-sm-2 control-label">No Telepon</label>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-phone"></i>
                                        </div>
                                        <input type="text" inputmode="numeric" class="form-control" id="phone" name="phone" value="{{ $data['phone'] }}" placeholder="No Telepon (jika ada)">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="id_line" class="col-sm-2 control-label">Line ID</label>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fab fa-line"></i>
                                        </div>
                                        <input type="text" class="form-control" id="id_line" name="id_line" value="{{ $data['id_line'] }}" placeholder="Line ID (jika ada)">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                @if(($data['status'] == 'bestnimda') || ($data['status'] == 'moderator') || ($data['status'] == 'treasurer') || ($data['status'] == 'instructor'))
                                <label for="no_msh" class="col-sm-2 control-label">No MSH</label>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fas fa-id-card"></i>
                                        </div>
                                        <input type="text" inputmode="numeric" class="form-control" id="no_msh" name="msh_pelatih" value="{{ $data['msh_pelatih'] }}" placeholder="No MSH">
                                    </div>
                                </div>
                                @elseif($data['status'] == 'participants')
                                <label for="noinduk" class="col-sm-2 control-label">No Induk</label>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fas fa-id-card"></i>
                                        </div>
                                        <input type="text" inputmode="numeric" class="form-control" id="noinduk" name="noinduk" value="{{ $data['noinduk'] }}" placeholder="No Induk">
                                    </div>
                                </div>
                                @else
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="lfm" class="col-sm-2 control-label">Foto Profil</label>
                                <div class="col-sm-10">
                                    <div class="input-group {{ $errors->has('avatar') ? 'has-error' : '' }}">
                                        <span class="input-group-btn">
                                            <a id="lfm" data-input="avatar" data-preview="holder" class="btn btn-primary">
                                                <i class="fa fa-picture-o"></i> Choose
                                            </a>
                                        </span>
                                        <input id="avatar" class="form-control" type="text" name="avatar" value="{{ $data['avatar'] }}">
                                        @if($errors->has('avatar'))<span class="help-block">{{ $errors->first('avatar') }}</span>@endif
                                    </div>
                                    <img id="holder" style="margin-top:15px;max-height:100px;">
                                </div>

                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary saveButton" id="editSimpan"><i class="fas fa-save"></i>&ensp;Simpan Perubahan</button>
                                </div>
                            </div>
                        </form>
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
<script src="{{ asset('js/user_profile.js') }}"></script>
<script src="/vendor/laravel-filemanager/js/lfm.js"></script>
<script>
    $(document).ready(function() {
        $('#lfm').filemanager('image');
    });
</script>
@endsection