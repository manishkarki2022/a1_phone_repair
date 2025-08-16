<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light border-bottom-0 shadow-sm">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars"></i>
            </a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ url('/') }}" class="nav-link">
                <i class="fas fa-home mr-1"></i> Home
            </a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->


        <!-- User Account Dropdown -->
        <li class="nav-item dropdown user-menu">
            <a class="nav-link dropdown-toggle d-flex align-items-center" data-toggle="dropdown" href="#" aria-expanded="false">
                <img src="{{ websiteInfo() && websiteInfo()->first() && websiteInfo()->logo_path ? asset('/storage/' . websiteInfo()->first()->logo_path) : asset('default/website-16x16.png') }}"
                     class="img-circle elevation-2 mr-2"
                     width="32"
                     height="32"
                     alt="User Image">
                <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right shadow">
                <!-- User image -->
                <div class="user-header bg-primary">
                    <img src="{{ websiteInfo() && websiteInfo()->first() && websiteInfo()->logo_path ? asset('/storage/' . websiteInfo()->first()->logo_path) : asset('default/website-16x16.png') }}"
                         class="img-circle elevation-2"
                         width="80"
                         height="80"
                         alt="User Image">
                    <p class="mb-0">
                        {{ Auth::user()->name }}
                        <small>Member since {{ Auth::user()->created_at->format('M. Y') }}</small>
                    </p>
                </div>
                <!-- Menu Footer-->
                <div class="user-footer">
                    <a href="{{ route('profile.edit') }}" class="btn btn-default btn-flat">
                        <i class="fas fa-user-cog mr-1"></i> Profile
                    </a>
                    <a href="{{ route('logout') }}"
                       class="btn btn-default btn-flat float-right text-danger"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt mr-1"></i> Sign out
                    </a>
                </div>
            </div>
        </li>
    </ul>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</nav>
<!-- /.navbar -->

<style>
    .navbar {
        padding: 0.4rem 1rem;
    }
    .navbar-light .navbar-nav .nav-link {
        color: #495057;
        font-weight: 500;
    }
    .user-header {
        padding: 1rem;
        text-align: center;
        color: white;
    }
    .user-header small {
        display: block;
        font-size: 0.8rem;
        opacity: 0.8;
    }
    .user-menu .dropdown-menu {
        border: none;
        min-width: 280px;
    }
    .user-footer {
        padding: 0.75rem;
        display: flex;
        justify-content: space-between;
    }
    .user-footer .btn {
        padding: 0.375rem 0.75rem;
    }
    .navbar-badge {
        position: absolute;
        top: 5px;
        right: 5px;
        font-size: 0.6rem;
    }
</style>

<script>
$(document).ready(function() {
    // Add active class to current nav item
    $('.navbar-nav .nav-link').filter(function() {
        return this.href == location.href;
    }).addClass('active');
});
</script>
