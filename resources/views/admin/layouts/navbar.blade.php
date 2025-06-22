<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">

    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item text-center align-items-center d-flex">
            <i class="far fa-calendar-alt" id="calendar-icon" style="margin-right: 5px;"></i>
            <span id="mypatro_nepali_date" class="text-primary"></span>
        </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>

            </a>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link p-0 pr-3" data-toggle="dropdown" href="#">
                    {{-- <img src="{{ websiteInfo()->isNotEmpty() && websiteInfo()->first()->logo ? asset('logo/' . websiteInfo()->first()->logo) : asset('logo/d_logo.png') }}" class='img-circle elevation-2' width="40" height="40" alt=""> --}}
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-3">
                <h4 class="h4 mb-0"><strong>{{ Auth::user()->name }}</strong></h4>
                <div class="mb-3">{{ Auth::user()->email }}</div>
                <div class="dropdown-divider"></div>
                {{-- <a href="{{route('profile.edit')}}" class="dropdown-item"> --}}
                    <i class="fas fa-user-cog mr-2"></i> Settings
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('logout') }}" class="dropdown-item text-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>
<!-- /.navbar -->
