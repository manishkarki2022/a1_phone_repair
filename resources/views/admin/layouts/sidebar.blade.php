<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="{{ websiteInfo() && websiteInfo()->logo_path ? asset('/storage/'.websiteInfo()->logo_path) : asset('storage/logo/d_logo.png') }}"
             alt="AdminLTE Logo"
             class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">
            {{ websiteInfo() && websiteInfo()->website_name ? websiteInfo()->website_name : 'My Website' }}
        </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">

            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name ?? 'Admin User' }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Site Settings -->
                <li class="nav-item">
                    <a href="{{ route('settings.index') }}" class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>Site Settings</p>
                    </a>
                </li>

                <!-- Category -->
               <li class="nav-item {{ request()->routeIs('device-categories.*') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ request()->routeIs('device-categories.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-th-large"></i>
        <p>
            Device Categories
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('device-categories.create') }}" class="nav-link {{ request()->routeIs('device-categories.create') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Add New Category</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('device-categories.index') }}" class="nav-link {{ request()->routeIs('device-categories.index') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>All Categories</p>
            </a>
        </li>
    </ul>
</li>

                <!-- Posts Menu -->
                <li class="nav-item {{ request()->routeIs('posts.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('posts.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-edit"></i>
                        <p>
                            Posts
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="" class="nav-link {{ request()->routeIs('posts.create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add New Post</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="" class="nav-link {{ request()->routeIs('posts.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Posts</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Pages Menu -->
                <li class="nav-item {{ request()->routeIs('pages.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('pages.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>
                            Pages
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="" class="nav-link {{ request()->routeIs('pages.create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add New Page</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="" class="nav-link {{ request()->routeIs('pages.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Pages</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Media Library -->
                <li class="nav-item">
                    <a href="" class="nav-link {{ request()->routeIs('media.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-images"></i>
                        <p>Media Library</p>
                    </a>
                </li>

                <!-- Users Management -->
                <li class="nav-item {{ request()->routeIs('users.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Users
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="" class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Users</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="" class="nav-link {{ request()->routeIs('users.create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add New User</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Separator -->
                <li class="nav-header">SYSTEM</li>

                <!-- Reports -->
                <li class="nav-item">
                    <a href="" class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>Reports</p>
                    </a>
                </li>

                <!-- System Logs -->
                <li class="nav-item">
                    <a href="" class="nav-link {{ request()->routeIs('logs.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-history"></i>
                        <p>System Logs</p>
                    </a>
                </li>

                <!-- Logout -->
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
