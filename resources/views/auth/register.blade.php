<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $title }}</title>
    <!-- CSS  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <!-- TOASTR -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!--  JS  -->
    <script src="https://cdn.jsdelivr.net/npm/node-forge@0.7.0/dist/forge.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/pdf.js-viewer@0.2.8/pdf.min.js"></script>
    <style>
        body {
            background: #222;
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('https://unsplash.it/1200/800/?random');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center center;
            background-fill-mode: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: white;
            padding: 20px 25px;
            border: 5px solid #26a69a;
            width: 550px;
            height: auto;
            box-sizing: border-box;
            position: relative;
        }

        .col.s6>.btn {
            width: 100%;
        }

        .container {
            animation: showUp 0.5s cubic-bezier(0.18, 1.3, 1, 1) forwards;
        }

        @keyframes showUp {
            0% {
                transform: scale(0);
            }

            100% {
                transoform: scale(1);
            }
        }

        .row {
            margin-bottom: 10px;
        }

        .ngl {
            position: absolute;
            top: -20px;
            right: -20px;
        }
    </style>
    <!-- </head> -->
    <div class="container">
        <div class="row">
            <form action="/daftar" method="POST" class="col s12" id="reg-form" accept-charset="ISO-8859-1">
                @csrf
                <div class="input-field">
                    <input placeholder="@if($errors->get('name')) Isi Nama Lengkap dengan benar @endif" id="name" type="text" class="validate" value="{{ old('name') }}" name="name" required="" maxlength="60" data-length="60">
                    <label for="name">Nama Lengkap</label>
                    @error('name') <span class="red-text">{{ $errors->first('name') }}</span> @enderror
                </div>
                <div class="input-field">
                    <input placeholder="@if($errors->get('email')) Isi Email dengan benar @endif" id="email_daftar" type="email" class="validate" value="{{ old('email') }}" name="email" required="" maxlength="60" data-length="60">
                    <label for="email_inline">Email</label>
                    @error('email') <span class="red-text">{{ $errors->first('email') }}</span> @enderror
                    <span class="helper-text" data-error="wrong" data-success="right"></span>
                </div>
                <div id="warn_pass">@error('pass_b') {{ 'Password Validasi Salah' }} @enderror</div>
                <div class="row">
                    <div class="col m6 s12">
                        <div class="input-field">
                            <input placeholder="" id="passwd_a" type="password" class="validate" name="pass_a" data-length="20" minlength="6" maxlength="20" required="">
                            <label for="passwd_a">Password</label>
                            <input type="hidden" name="hide" id="dafHide" />
                        </div>
                    </div>
                    <div class="col m6 s12">
                        <div class="input-field">
                            <input placeholder="" id="passwd_b" type="password" class="validate" name="pass_b" data-length="20" minlength="6" maxlength="20" required="">
                            <label for="passwd_b">Password Validasi</label>
                        </div>
                    </div>
                </div>
                <button class="btn waves-effect waves-light" id="startRegister" type="submit" onclick="return encDaf()">Daftar<i class="material-icons right">send</i></button>
            </form>
        </div>
        <a href="{{ route('login') }}" title="Login" class="ngl btn-floating btn-large waves-effect waves-light red"><i class="material-icons">input</i></a>
    </div>
    @if(session('failed'))<div class="hide-flashdata" id="failed" data-flashdata="{{ session('failed') }}"></div>@endif
    <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    @include('layouts.includes._sweetalert')
    @include('layouts.includes._forgejs')
    <script src="{{ asset('js/materialize_register.js') }}"></script>
    <!-- </body></html> -->