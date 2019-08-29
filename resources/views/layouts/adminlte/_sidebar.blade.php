<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ getUserAvatar() }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ auth()->user()->name }}</p>
                <a href="#"><i class="fas fa-circle text-success"></i> {{ getStatusUserById(auth()->user()->status) }}</a>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">DASHBOARD MENU</li>

            <li @if(Request::segment(1)=='home' ) class="active" @endif><a href="/home"><i class="fas fa-home"></i><span>&ensp;Home</span></a></li>

            @if(auth()->user()->status == 'bestnimda')
            <li @if(Request::segment(1)=='posting' ) class="active" @endif><a href="/posting"><i class="fas fa-feather-alt"></i><span>&ensp;Posting</span></a></li>
            <li @if(Request::segment(1)=='setting' ) class="active" @endif><a href="{{ route('admin.setting') }}"><i class="fas fa-cogs"></i><span>&ensp;Admin Setting</span><span class="pull-right-container">@if(getCountOfNewGuests() > 0)<small class="label pull-right bg-yellow">{{ getCountOfNewGuests() }}</small>@endif</span></a></li>
            @endif

            @if(auth()->user()->status == 'moderator')
            <li @if(Request::segment(1)=='kelas' ) class="active" @endif><a href="{{ route('kelas.home') }}"><i class="fas fa-building"></i><span>&ensp;Kelas</span></a></li>
            <li @if(Request::segment(1)=='materi' ) class="active" @endif><a href="/materi"><i class="fas fa-book-reader"></i><span>&ensp;Materi Ujian</span></a></li>
            <li @if(Request::segment(1)=='pengaturan' ) class="active" @endif><a href="{{ route('moderator.pengaturan') }}"><i class="fas fa-cogs"></i><span>&ensp;Pengaturan</span><span class="pull-right-container">@if(getCountModReqOtt() > 0)<small class="label pull-right bg-yellow">{{ getCountModReqOtt() }}</small>@endif</span></a></li>
            @endif

            @if(auth()->user()->status == 'treasurer')
            <li @if(Request::segment(1)=='kelas' ) class="active" @endif><a href="{{ route('kelas.home') }}"><i class="fas fa-building"></i><span>&ensp;Kelas</span></a></li>
            <li @if(Request::segment(1)=='materi' ) class="active" @endif><a href="/materi"><i class="fas fa-book-reader"></i><span>&ensp;Materi Ujian</span></a></li>
            @endif

            @if(auth()->user()->status == 'instructor')
            <li @if(Request::segment(1)=='kelas' ) class="active" @endif><a href="{{ route('kelas.home') }}"><i class="fas fa-building"></i><span>&ensp;Kelas</span></a></li>
            <li @if(Request::segment(1)=='materi' ) class="active" @endif><a href="/materi"><i class="fas fa-book-reader"></i><span>&ensp;Materi Ujian</span></a></li>
            @endif

            @if(auth()->user()->status == 'participants')
            <li @if(Request::segment(1)=='latihan' ) class="active" @endif><a href="/latihan"><i class="fas fa-running"></i><span>&ensp;Latihan</span></a></li>
            <li @if(Request::segment(1)=='materi' ) class="active" @endif><a href="/materi"><i class="fas fa-book-reader"></i><span>&ensp;Materi Ujian</span></a></li>
            <li @if(Request::segment(1)=='persyaratan' ) class="active" @endif><a href="/persyaratan"><i class="fas fa-file-invoice-dollar"></i><span>&ensp;Persyaratan Ujian</span></a></li>
            <li @if(Request::segment(1)=='spp_peserta' ) class="active" @endif><a href="/spp_peserta"><i class="fas fa-money-check-alt"></i><span>&ensp;SPP</span></a></li>
            @endif

            @if(auth()->user()->status == 'parents')
            <li @if(Request::segment(1)=='latihan' ) class="active" @endif><a href="/latihan"><i class="fas fa-running"></i><span>&ensp;Latihan</span></a></li>
            <li @if(Request::segment(1)=='persyaratan' ) class="active" @endif><a href="/persyaratan"><i class="fas fa-file-invoice-dollar"></i><span>&ensp;Persyaratan Ujian</span></a></li>
            <li @if(Request::segment(1)=='spp_peserta' ) class="active" @endif><a href="/spp_peserta"><i class="fas fa-money-check-alt"></i><span>&ensp;SPP</span></a></li>
            @endif

            @if((auth()->user()->status == 'guests') || (auth()->user()->status == 'parents') || (needOtentificationAgain() == 'OK'))
            <li @if(Request::segment(1)=='otentifikasi' ) class="active" @endif><a href="/otentifikasi"><i class="fas fa-file-signature"></i><span>&ensp;Otentifikasi</span></a></li>
            @endif
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>