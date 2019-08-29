@extends('layouts.master')

@section('header')
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
                            <div class="profile-main">
                                <img src="{{ getAvatarUserById($data['id']) }}" class="img-circle" style="height:120px;max-width:120px;width: expression(this.width > 500 ? 500: true);">
                                <h3 class="name">{{ $data['name'] }}</h3>
                                <span class="online-status status-available">{{ getStatusUserById($data['status']) }}</span>
                            </div>
                        </div>
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
                    </div>
                    <div class="profile-right">
                        <h4 class="heading">Edit User</h4>
                        <div class="awards">
                            @if(convStatUserToIndex($data['status']) != '6')
                            <form action="/setting/apps/users/{{ $data['id'] }}/edit" method="POST">
                                @csrf
                                <input type="hidden" name="type" value="updateToModerator" readonly>
                                <input type="hidden" name="name_user" value="{{ $data['name'] }}" readonly>
                                <button type="submit" class="btn @if(convStatUserToIndex($data['status']) <= 1) btn-primary @else btn-danger @endif" id="updToMod"><i class="fas fa-upload"></i>&ensp;Jadikan Moderator</button>
                            </form>
                            @endif
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
<script src="{{ asset('js/prog_setting_admin.js') }}"></script>

@endsection