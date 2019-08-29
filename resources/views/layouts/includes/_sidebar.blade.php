<div id="sidebar-nav" class="sidebar">
	<div class="sidebar-scroll">
		<nav>
			<ul class="nav">
				<li><a href="{{ route('home') }}" @if(Request::segment(1)=='home' ) class="active" @endif><i class="fas fa-home fa-lg"></i> <span> Home</span></a></li>
				@if(auth()->user()->status == 'bestnimda')
				<li><a href="{{ route('kelas.home') }}" @if(Request::segment(1)=='kelas' ) class="active" @endif><i class="fas fa-building fa-lg"></i> <span> Kelas</span></a></li>
				<li><a href="/posting" @if(Request::segment(1)=='posting' ) class="active" @endif><i class="fas fa-feather-alt fa-lg"></i> <span> Posting</span></a></li>
				<li><a href="{{ route('admin.setting') }}" @if(Request::segment(1)=='setting' ) class="active" @endif><i class="fas fa-cogs fa-lg"></i> <span> Setting</span></a></li>
				@endif
				@if(auth()->user()->status == 'moderator')
				<li><a href="{{ route('kelas.home') }}" @if(Request::segment(1)=='kelas' ) class="active" @endif><i class="fas fa-building fa-lg"></i> <span> Kelas</span></a></li>
				<li><a href="{{ route('moderator.pengaturan') }}" @if(Request::segment(1)=='pengaturan' ) class="active" @endif><i class="fas fa-cogs fa-lg"></i> <span> Pengaturan</span></a></li>
				@endif
			</ul>
		</nav>
	</div>
</div>