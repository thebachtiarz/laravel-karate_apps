<!doctype html>
<html lang="en">

<head>
    <title>{{ $title }}</title>
    <!-- ICONS -->
    <link rel="icon" type="image/png" sizes="96x96" href="{{asset('klorofil')}}/assets/img/favicon.png">
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('klorofil')}}/assets/img/apple-icon.png">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <!-- VENDOR CSS -->
    <link rel="stylesheet" href="{{asset('klorofil')}}/assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('klorofil')}}/assets/vendor/font-awesome/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/efb82a8e63.js"></script>
    <link rel="stylesheet" href="{{asset('klorofil')}}/assets/vendor/linearicons/style.css">
    <!-- MAIN CSS -->
    <link rel="stylesheet" href="{{asset('klorofil')}}/assets/css/main.css">
    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
    <!-- TOASTR -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- </head><body> -->
    <!-- WRAPPER -->
    <div id="wrapper">
        <!-- NAVBAR -->
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="brand">
                <a href="/"><img src="{{asset('klorofil')}}/assets/img/logo-dark.png" alt="Klorofil Logo" class="img-responsive logo"></a>
            </div>
            <div class="container-fluid">
                <div class="navbar-btn">
                    <button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-arrow-left-circle"></i></button>
                </div>
                <div id="navbar-menu">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="" class="dropdown-toggle" data-toggle="dropdown"><img src="{{ getUserAvatar() }}" class="img-circle" alt="Avatar"> <span>{{ auth()->user()->name }}</span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ route('user.profile') }}"><i class="fas fa-user-shield"></i> <span>My Profile</span></a></li>
                                <li><a href="{{ route('logout') }}"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- END NAVBAR -->
        <!-- LEFT SIDEBAR -->
        <div id="sidebar-nav" class="sidebar">
            <div class="sidebar-scroll">
                <nav>
                    <ul class="nav">
                        <li><a href="/home" class="active"><i class="fas fa-home fa-lg"></i> <span> Home</span></a></li>
                    </ul>
                </nav>
            </div>
        </div>
        <!-- END LEFT SIDEBAR -->
        <!-- MAIN -->
        <div class="main">
            <!-- MAIN CONTENT -->
            <div class="main-content">
                <div class="container-fluid">
                    {{ createBreadcrumbByArrayOfCode([]) }}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-headline">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Hai, Apa Kabar {{ createGreetingsByTimeNow() }}</h3>
                                </div>
                                <div class="panel-body">
                                    <blockquote class="blockquote alert-info">
                                        <p class="mb-0">Anda belum melakukan otentifikasi pada akun ini, silahkan untuk segera menghubungi pelatih ranting/cabang anda. Terima Kasih.</p>
                                        <div class="blockquote-footer" style="font-style: italic; font-family: courier new;"> Karate Apps.</div>
                                    </blockquote>
                                    <blockquote class="blockquote alert-danger">
                                        <p class="mb-0">Akun anda akan otomatis dihapus oleh sistem pada tanggal {{ conv_getDate($expire) }} apabila anda tidak segera melakukan otentifikasi.</p>
                                        <div class="blockquote-footer" style="font-style: italic; font-family: courier new;"> Karate Apps.</div>
                                    </blockquote>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END MAIN -->
        <div class="clearfix"></div>
        <footer>
            <div class="container-fluid">
                <p class="copyright">&copy; 2017 <a href="https://www.themeineed.com" target="_blank">Theme I Need</a>. All Rights Reserved.</p>
            </div>
        </footer>
    </div>
    <!-- END WRAPPER -->
    <!-- Javascript -->
    <script src="{{asset('klorofil')}}/assets/vendor/jquery/jquery.min.js"></script>
    <script src="{{asset('klorofil')}}/assets/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="{{asset('klorofil')}}/assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <script src="{{asset('klorofil')}}/assets/scripts/klorofil-common.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    @include('layouts.includes._toastralert')

    <!-- </body></html> -->