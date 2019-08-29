@extends('layouts.masterlte')

@section('header')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('content')

<section class="content-header">
    <h1>Terminal</h1>
    {!! createBreadcrumbByArrayOfCode(['terminal']) !!}
</section>

<section class="content">
    <div class="input-group">
        <span class="input-group-addon"><i class="fas fa-terminal"></i></span>
        <input type="text" class="form-control thisQuery" placeholder="Input Query" onclick="this.placeholder=''" onblur="this.placeholder='Input Query'">
    </div>
    <div class="input-group" style="padding-top: 10px; padding-bottom: 10px;">
        <button type="submit" class="btn btn-danger buttonPost">POST</button>
    </div>
    <div id="postValueAjax"></div>
</section>

@endsection

@section('footer')
<script src="{{ asset('js/menu_terminal_admin.js') }}"></script>
@endsection