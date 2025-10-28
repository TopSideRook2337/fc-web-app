<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard') }}" class="brand-link text-decoration-none">
        <img src="{{ asset('vendor/adminlte/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Футбольный клуб</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Новости -->
                <li class="nav-item {{ request()->routeIs('admin.posts.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-newspaper"></i>
                        <p>
                            Новости
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.posts.index') }}" class="nav-link ">
                                <i class="nav-icon fas fa-list"></i>
                                <p>Список новостей</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.posts.create') }}" class="nav-link {{ request()->routeIs('admin.posts.create') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-plus"></i>
                                <p>Создать новость</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Матчи -->
                <li class="nav-item {{ request()->routeIs('admin.games.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('admin.games.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-futbol"></i>
                        <p>
                            Матчи
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.games.index') }}" class="nav-link {{ request()->routeIs('admin.games.index') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-list"></i>
                                <p>Список матчей</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.games.create') }}" class="nav-link {{ request()->routeIs('admin.games.create') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-plus"></i>
                                <p>Создать матч</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Стадионы -->
                <li class="nav-item {{ request()->routeIs('admin.stadiums.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('admin.stadiums.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-building"></i>
                        <p>
                            Стадионы
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.stadiums.index') }}" class="nav-link {{ request()->routeIs('admin.stadiums.index') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-list"></i>
                                <p>Список стадионов</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.stadiums.create') }}" class="nav-link {{ request()->routeIs('admin.stadiums.create') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-plus"></i>
                                <p>Создать стадион</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Схемы стадионов -->
                <li class="nav-item {{ request()->routeIs('admin.stadium-schemes.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('admin.stadium-schemes.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-map"></i>
                        <p>
                            Схемы стадионов
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.stadium-schemes.index') }}" class="nav-link {{ request()->routeIs('admin.stadium-schemes.index') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-list"></i>
                                <p>Список схем</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.stadium-schemes.upload') }}" class="nav-link {{ request()->routeIs('admin.stadium-schemes.upload') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-upload"></i>
                                <p>Загрузить схему</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Заказы -->
                <li class="nav-item">
                    <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>Заказы</p>
                    </a>
                </li>

                <!-- Билеты -->
                <li class="nav-item">
                    <a href="{{ route('admin.tickets.index') }}" class="nav-link {{ request()->routeIs('admin.tickets.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-ticket-alt"></i>
                        <p>Билеты</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
