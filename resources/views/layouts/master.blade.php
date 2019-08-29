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

	@yield('header')
	<!-- </head><body> -->
	<!-- WRAPPER -->
	<div id="wrapper">
		<!-- NAVBAR -->
		@include('layouts.includes._navbar')
		<!-- END NAVBAR -->
		<!-- LEFT SIDEBAR -->
		@include('layouts.includes._sidebar')
		<!-- END LEFT SIDEBAR -->
		<!-- MAIN -->
		@yield('content')
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
	<!-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.4.0/dist/jquery.min.js" integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg=" crossorigin="anonymous"></script> -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="{{asset('klorofil')}}/assets/vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="{{asset('klorofil')}}/assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<script src="{{asset('klorofil')}}/assets/scripts/klorofil-common.js"></script>
	@yield('footer')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
	@include('layouts.includes._toastralert')
	<!-- </body></html> -->