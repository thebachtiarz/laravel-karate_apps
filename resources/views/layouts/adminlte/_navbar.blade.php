<header class="main-header">
    <!-- Logo -->
    <a href="/" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>K</b>A</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Karate</b> Apps</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ getUserAvatar() }}" class="user-image" alt="User Image">
                        <span class="hidden-xs">{{ auth()->user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="{{ getUserAvatar() }}" class="img-circle" alt="User Image">
                            <p>
                                {{ auth()->user()->name }}
                                <small>{{ getStatusUserById(auth()->user()->status) }}</small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="{{ route('user.profile') }}" class="btn btn-sm btn-default"><i class="fas fa-id-badge"></i>&ensp;Profile</a>
                            </div>
                            @if(auth()->user()->status == 'bestnimda')
                            <div class="pull-left">
                                &ensp;
                                <a href="{{ route('admin.menu.terminal') }}" class="btn btn-sm btn-default"><i class="fas fa-terminal"></i>&ensp;Terminal</a>
                            </div>
                            @endif
                            <div class="pull-right">
                                <a href="{{ route('logout') }}" class="btn btn-sm btn-default"><i class="fas fa-sign-out-alt"></i>&ensp;Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>