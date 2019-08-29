<!doctype html>
<html lang="en" class="fullscreen-bg">

<head>
    <title>Login Apps</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <!-- VENDOR CSS -->
    <link rel="stylesheet" href="{{asset('klorofil/assets/css/bootstrap.min.css')}}">
    <script src="{{ url('js/kit_fontawesome.js') }}"></script>
    <!-- MAIN CSS -->
    <link rel="stylesheet" href="{{asset('klorofil/assets/css/main.css')}}">
    <!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
    <link rel="stylesheet" href="{{asset('klorofil/assets/css/demo.css')}}">
    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
    <!-- ICONS -->
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('klorofil/assets/img/apple-icon.png')}}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{asset('klorofil/assets/img/favicon.png')}}">
    <!-- TOASTR -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- </head><body> -->

    <!-- WRAPPER -->
    <div id="wrapper">
        <div class="vertical-align-wrap">
            <div class="vertical-align-middle">
                <div class="auth-box ">
                    <div class="left">
                        <div class="content">
                            <div class="header">
                                <div class="logo text-center"><img src="{{asset('klorofil/assets/img/logo-dark.png')}}" alt="Klorofil Logo"></div>
                                <p class="lead">Login to your account</p>
                            </div>
                            <form class="form-auth-small was-validated" action="{{ route('login') }}" method="post" accept-charset="ISO-8859-1">
                                @csrf
                                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                                    <label for="signin-email" class="control-label sr-only">Email</label>
                                    <input type="email" class="form-control" id="signin-email" name="email" placeholder="@if($errors->get('email')) Isi Email dengan benar @else Email @endif" value="{{ old('email') }}" onclick="this.placeholder=''" onblur="this.placeholder='@if($errors->get('email')) Isi Email dengan benar @else Email @endif'">
                                </div>
                                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                                    <label for="passwd_login" class="control-label sr-only">Password</label>
                                    <input type="password" class="form-control" id="passwd_login" name="password" placeholder="@if($errors->get('password')) Isi Password dengan benar @else Password @endif" onclick="this.placeholder=''" onblur="this.placeholder='@if($errors->get('password')) Isi Password dengan benar @else Password @endif'">
                                    <input type="hidden" name="hide" id="logHide" />
                                </div>
                                <!-- <div class="form-group clearfix">
									<label class="fancy-checkbox element-left">
										<input type="checkbox">
										<span>Remember me</span>
									</label>
								</div> -->
                                @if(session('pull'))<input type="hidden" name="count" value="{{ session('pull') }}">@endif
                                <button type="submit" class="btn btn-primary btn-lg btn-block" onclick="return encLog()">LOGIN</button>
                                <div class="bottom text-left">
                                    <i class="fas fa-user-plus"></i>&emsp;<a href="/daftar">Daftar</a>
                                    <br>
                                    <i class="fas fa-user-lock"></i>&emsp;<a href="/lupa_password">Lupa Password?</a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="right">
                        <div class="overlay"></div>
                        <div class="content text">
                            <h1 class="heading">Karate Apps</h1>
                            <p>by Bachtiar.</p>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- END WRAPPER -->
    <script src="{{asset('klorofil/assets/vendor/jquery/jquery.min.js')}}"></script>

    @include('layouts.includes._forgejs')
    @include('layouts.includes._toastralert')

    <!-- </body></html> -->