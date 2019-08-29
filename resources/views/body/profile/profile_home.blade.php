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
</style>
@endsection

@section('content')
<div class="main">
    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-profile">
                        <div class="clearfix">
                            <!-- LEFT COLUMN -->
                            <div class="profile-left">
                                <!-- PROFILE HEADER -->
                                <div class="profile-header">
                                    <div class="overlay"></div>
                                    <div class="profile-main">
                                        <img src="{{ getUserAvatar() }}" class="img-circle" style="height:120px;max-width:120px;width: expression(this.width > 500 ? 500: true);">
                                        <h3 class="name">{{ $data['name'] }}</h3>
                                        <span class="online-status status-available">{{ getStatusUserById($data['status']) }}</span>
                                    </div>
                                </div>
                                <!-- END PROFILE HEADER -->
                                <!-- PROFILE DETAIL -->
                                <div class="profile-detail">
                                    <div class="profile-info">
                                        <h4 class="heading">Basic Info</h4>
                                        <ul class="list-unstyled list-justify">
                                            <li>Born <span>{{ conv_getDate($data['born']) }}</span></li>
                                            <li>Phone <span>{{ $data['phone'] }}</span></li>
                                            <li>Line_ID <span>{{ $data['id_line'] }}</span></li>
                                            <li>Email <span>{{ $data['email'] }}</span></li>
                                            @if(($data['status'] == 'bestnimda') || ($data['status'] == 'moderator') || ($data['status'] == 'treasurer') || ($data['status'] == 'instructor'))
                                            <li>MSH <span>{{ $data['msh_pelatih'] }}</span></li>
                                            @elseif($data['status'] == 'participants')
                                            <li>No Induk <span>{{ $data['noinduk'] }}</span></li>
                                            @else
                                            @endif
                                            <li>Bergabung <span>{{ conv_getDate($data['created_at']) }}</span></li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- END PROFILE DETAIL -->
                            </div>
                            <!-- END LEFT COLUMN -->
                            <!-- RIGHT COLUMN -->
                            <div class="profile-right">
                                <!-- TABBED CONTENT -->
                                <div class="custom-tabs-line tabs-line-bottom left-aligned">
                                    <ul class="nav" role="tablist">
                                        <li class="active"><a href="#tab-bottom-left1" role="tab" data-toggle="tab">Recent Activity</a></li>
                                        <li><a href="#tab-bottom-left2" role="tab" data-toggle="tab">Edit Biodata</a></li>
                                    </ul>
                                </div>
                                <div class="tab-content">
                                    <div class="tab-pane fade in active" id="tab-bottom-left1">

                                    </div>
                                    <div class="tab-pane fade" id="tab-bottom-left2">
                                        <form action="" method="POST" class="was-validated" enctype="multipart/form-data" accept-charset="ISO-8859-1">
                                            @csrf <input type="hidden" name="type" value="editbio" readonly>
                                            <div class="form-group">
                                                <label for="fullname">Nama Lengkap</label>
                                                <input type="text" class="form-control" id="fullname" name="name" value="{{ $data['name'] }}" placeholder="Nama Lengkap" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="born">Tanggal Lahir</label>
                                                <input type="date" class="form-control" id="born" name="born" value="@if($data['born'] != NULL){{ $data['born'] }}@else {{ '2002-01-01' }} @endif" placeholder="Tanggal Lahir">
                                            </div>
                                            <div class="form-group">
                                                <label for="phone">No Telepon</label>
                                                <input type="text" class="form-control" id="phone" name="phone" value="{{ $data['phone'] }}" placeholder="No Telepon (jika ada)">
                                            </div>
                                            <div class="form-group">
                                                <label for="id_line">Line ID</label>
                                                <input type="text" class="form-control" id="id_line" name="id_line" value="{{ $data['id_line'] }}" placeholder="Line ID (jika ada)">
                                            </div>
                                            <div class="form-group">
                                                @if(($data['status'] == 'bestnimda') || ($data['status'] == 'moderator') || ($data['status'] == 'treasurer') || ($data['status'] == 'instructor'))
                                                <label for="no_msh">No MSH</label>
                                                <input type="text" class="form-control" id="no_msh" name="msh_pelatih" value="{{ $data['msh_pelatih'] }}" placeholder="No MSH">
                                                @elseif($data['status'] == 'participants')
                                                <label for="noinduk">No Induk</label>
                                                <input type="text" class="form-control" id="noinduk" name="noinduk" value="{{ $data['noinduk'] }}" placeholder="No Induk">
                                                @else
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="lfm">Foto Profil</label><br>
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
                                            <button type="submit" class="btn btn-primary saveButton" id="editSimpan"><i class="fas fa-save"></i>&ensp;Simpan Perubahan</button>
                                        </form>
                                    </div>
                                </div>
                                <!-- END TABBED CONTENT -->
                            </div>
                            <!-- END RIGHT COLUMN -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('footer')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8.13.0/dist/sweetalert2.all.min.js" integrity="sha256-aakU0ciz46DahtBruJmV8isJWXw6TELTYFPcSVVcoFU=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script>
<script src="{{ asset('js/user_profile.js') }}"></script>
<script src="/vendor/laravel-filemanager/js/lfm.js"></script>
<script>
    $(document).ready(function() {
        $('#lfm').filemanager('image');
    });
</script>
@endsection