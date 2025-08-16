<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="{{ websiteInfo() && websiteInfo()->logo_path ? asset('/storage/'.websiteInfo()->logo_path) : asset('storage/logo/d_logo.png') }}"
             alt="AdminLTE Logo"
              class="img-fluid mb-2 rounded-circle"
             style="max-height: 80px; width: 80px; object-fit: cover;">
        <span class="brand-text font-weight-light">
            {{ websiteInfo() && websiteInfo()->website_name ? websiteInfo()->website_name : 'My Website' }}
        </span>
    </a>
    @php
            use Carbon\Carbon;

            $hour = Carbon::now()->format('H');
            $greeting = match (true) {
                $hour < 12 => 'Good Morning',
                $hour < 17 => 'Good Afternoon',
                $hour < 20 => 'Good Evening',
                default   => 'Good Night',
            };
        @endphp
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel  p-2  d-flex">
            <div class="info">
                <p class="d-block text-white">
                    <b>{{ $greeting }},</b> {{ auth()->user()->name ?? 'Admin User' }}
                </p>
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

                <!-- Customer Bookings -->
                <li class="nav-item {{ request()->routeIs('customer-bookings.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('customer-bookings.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-calendar-check"></i>
                        <p>
                            Customer Bookings
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('customer-bookings.create') }}" class="nav-link {{ request()->routeIs('customer-bookings.create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Create New Booking</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('customer-bookings.index') }}" class="nav-link {{ request()->routeIs('customer-bookings.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Bookings</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-header">Content Management</li>

                <!-- Site Settings -->
                <li class="nav-item">
                    <a href="{{ route('settings.index') }}" class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>Site Settings</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('admin.banners.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-bullhorn"></i>
                        <p>
                            Discount Banners
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('banners.index') }}" class="nav-link {{ request()->routeIs('banners.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Banners</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('banners.create') }}" class="nav-link {{ request()->routeIs('banners.create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add New</p>
                            </a>
                        </li>
                    </ul>
                </li>
                 <li class="nav-header">Device & Service Management</li>

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

                <!-- Device Types -->
                <li class="nav-item {{ request()->routeIs('device-types.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('device-types.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-mobile-alt"></i>
                        <p>
                            Device Types
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('device-types.create') }}" class="nav-link {{ request()->routeIs('device-types.create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add New Type</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('device-types.index') }}" class="nav-link {{ request()->routeIs('device-types.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Types</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Repair Services -->


                <li class="nav-item {{ request()->routeIs('repair-services.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('repair-services.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tools"></i>
                        <p>
                            Repair Services
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('repair-services.create') }}" class="nav-link {{ request()->routeIs('repair-services.create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add New Service</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('repair-services.index') }}" class="nav-link {{ request()->routeIs('repair-services.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Services</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- Contact Submissions -->
                <li class="nav-item {{ request()->routeIs('admin.contacts.*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-envelope"></i>
                    <p>
                        Contact Submissions
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('contacts.index') }}" class="nav-link {{ request()->routeIs('admin.contacts.index') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>All Submissions</p>
                        </a>
                    </li>
                </ul>
                </li>
                <!-- Separator -->
                <li class="nav-header">SYSTEM</li>

               <!-- Reports -->
                <li class="nav-item">
                    <a href="{{ route('reports.index') }}"
                    class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>Reports</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
