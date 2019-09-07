<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $title }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ offline_asset() }}/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ offline_asset() }}/bower_components/font-awesome/css/font-awesome.min.css">
    <script src="{{ url('js/kit_fontawesome.js') }}"></script>
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ online_asset() }}/bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ online_asset() }}/dist/css/AdminLTE.min.css">
    <!-- TOASTR -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <!-- </head><body> -->

<body class="hold-transition skin-blue fixed register-page">
    <div class="register-box">
        <div class="register-logo">
            <b>Register </b>Apps
        </div>

        <div class="register-box-body rounded">
            <p class="login-box-msg">Form Pendaftaran</p>

            <form action="/daftar" method="POST" class="col s12" id="reg-form" accept-charset="ISO-8859-1">@csrf
                <div class="form-group has-feedback">
                    <input type="text" name="name" class="form-control" id="name" placeholder="@if($errors->get('name')) Isi Nama Lengkap dengan benar @else Nama Lengkap @endif" value="{{ old('name') }}" required="" maxlength="60" data-length="60">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="email" class="form-control" id="email_daftar" placeholder="@if($errors->get('email')) Isi Email dengan benar @else Email @endif" value="{{ old('email') }}" name="email" required="" maxlength="60" data-length="60">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div id="warn_pass">@error('pass_b') <p class="text-red text-bold">{{ 'Password Validasi Salah' }}</p> @enderror</div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" id="passwd_a" placeholder="Password" minlength="6" maxlength="20" data-length="20" required="">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" id="passwd_b" placeholder="Retype password" minlength="6" maxlength="20" data-length="20" required="">
                    <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-8"></div>
                    <div class="col-xs-4">
                        <input type="hidden" id="back_passwd_a" name="pass_a" minlength="96" maxlength="96" readonly required="">
                        <input type="hidden" id="back_passwd_b" name="pass_b" minlength="96" maxlength="96" readonly required="">
                        <button type="submit" class="btn btn-primary btn-block btn-flat" id="startRegister" onclick="return encDaf()">Daftar</button>
                    </div>
                </div>
            </form>

            <a href="/" class="text-center">Saya sudah punya akun</a>
        </div>
    </div>

    <!-- jQuery 3 -->
    <script src="{{ online_asset() }}/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ online_asset() }}/bower_components/jquery-ui/jquery-ui.min.js"></script>
    @if(session('failed'))<div class="hide-flashdata" id="failed" data-flashdata="{{ session('failed') }}"></div>@endif
    <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8.13.0/dist/sweetalert2.all.min.js" integrity="sha256-aakU0ciz46DahtBruJmV8isJWXw6TELTYFPcSVVcoFU=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.js"></script>
    @include('layouts.includes._toastralert')
    @include('layouts.includes._forgejs')
    <script src="{{ asset('js/materialize_register.js') }}"></script>
    <script>
        function mediascreen(x) {
            if (!x.matches) {
                location.replace('daftar');
            }
        }

        var x = window.matchMedia("(max-width: 600px)");
        mediascreen(x);
        x.addListener(mediascreen);
    </script>
    <!-- </body></html> -->