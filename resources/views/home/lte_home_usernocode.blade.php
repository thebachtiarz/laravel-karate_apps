@extends('layouts.masterlte')

@section('header')
@endsection

@section('content')

<section class="content-header">
    <h1>Home</h1>
    {!! createBreadcrumbByArrayOfCode([]) !!}
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-headline">
                    <div class="panel-heading">
                        <h3 class="panel-title">Hai, Apa Kabar {{ createGreetingsByTimeNow() }}</h3>
                    </div>
                    <div class="panel-body">
                        <blockquote class="blockquote alert-info" style="background-color: #D9EDF7; color: #31708F;">
                            <p class="mb-0">Anda belum melakukan otentifikasi pada akun ini, silahkan untuk segera menghubungi pelatih ranting/cabang anda. Terima Kasih.</p>
                            <div class="blockquote-footer" style="font-style: italic; font-family: courier new;"> Karate Apps.</div>
                        </blockquote>
                        <blockquote class="blockquote alert-danger" style="background-color: #F8D7DA; color: #721C24;">
                            <p class="mb-0">Akun anda akan otomatis dihapus oleh sistem pada tanggal {{ conv_getDate($expire) }} apabila anda tidak segera melakukan otentifikasi.</p>
                            <div class="blockquote-footer" style="font-style: italic; font-family: courier new;"> Karate Apps.</div>
                        </blockquote>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('footer')
@endsection