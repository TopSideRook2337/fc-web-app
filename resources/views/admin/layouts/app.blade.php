<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Админ-панель') - {{ config('app.name', 'Laravel') }}</title>

    <!-- Инлайн-скрипт для немедленного применения темы (до загрузки CSS) -->
    <script>
        (function() {
            const savedTheme = localStorage.getItem('admin-theme') || 'light';
            if (savedTheme === 'dark') {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>

    <!-- Инлайн-стили для предотвращения белой вспышки -->
    <style>
        html {
            background-color: #111827 !important;
        }
        html:not(.dark) {
            background-color: #F9FAFB !important;
        }
        body {
            background-color: inherit !important;
        }
    </style>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

    @stack('styles')
    
    <style>
        /* CSS-переменные для темизации */
        :root {
            /* Светлая тема */
            --bg-primary: #F9FAFB;
            --bg-secondary: #FFFFFF;
            --bg-card: #FFFFFF;
            --bg-sidebar: #343a40;
            --text-primary: #111827;
            --text-secondary: #6B7280;
            --text-muted: #9CA3AF;
            --text-sidebar: #FFFFFF;
            --border-color: #E5E7EB;
            --border-light: #F3F4F6;
            --border-sidebar: #495057;
            --accent-primary: #2563EB;
            --accent-success: #10B981;
            --accent-warning: #F59E0B;
            --accent-danger: #EF4444;
            --accent-purple: #7C3AED;
            --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 1px 3px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 4px 6px rgba(0, 0, 0, 0.1);
            --shadow-xl: 0 10px 15px rgba(0, 0, 0, 0.1);
            --table-header-hover-bg: #F3F4F6;
            --table-header-hover-text: #111827;
            --table-header-hover-border: #D1D5DB;
            --table-sort-icon: #6B7280;
            --table-sort-icon-hover: #374151;
        }
        
        .dark {
            /* Тёмная тема */
            --bg-primary: #111827;
            --bg-secondary: #1F2937;
            --bg-card: #1F2937;
            --bg-sidebar: #1F2937;
            --text-primary: #F9FAFB;
            --text-secondary: #D1D5DB;
            --text-muted: #9CA3AF;
            --text-sidebar: #F9FAFB;
            --border-color: #374151;
            --border-light: #374151;
            --border-sidebar: #374151;
            --accent-primary: #3B82F6;
            --accent-success: #059669;
            --accent-warning: #D97706;
            --accent-danger: #DC2626;
            --accent-purple: #8B5CF6;
            --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.3);
            --shadow-md: 0 1px 3px rgba(0, 0, 0, 0.4);
            --shadow-lg: 0 4px 6px rgba(0, 0, 0, 0.4);
            --shadow-xl: 0 10px 15px rgba(0, 0, 0, 0.4);
            --table-header-hover-bg: #374151;
            --table-header-hover-text: #FFFFFF;
            --table-header-hover-border: #4B5563;
            --table-sort-icon: #9CA3AF;
            --table-sort-icon-hover: #FFFFFF;
        }
        
        /* Базовые стили с использованием переменных */
        body {
            background-color: var(--bg-primary) !important;
            color: var(--text-primary);
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        
        .content-wrapper {
            background-color: var(--bg-primary);
            transition: background-color 0.3s ease;
        }
        
        .card, .info-box, .small-box {
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }
        
        .table {
            transition: background-color 0.3s ease;
        }
        
        .main-header {
            background-color: var(--bg-secondary);
            border-bottom: 1px solid var(--border-color);
        }
        
        .main-sidebar {
            background-color: var(--bg-sidebar);
            border-right: 1px solid var(--border-sidebar);
        }
        
        .brand-link {
            color: var(--text-sidebar);
        }
        
        .nav-link {
            color: var(--text-sidebar);
        }
        
        .nav-link:hover,
        .nav-link.active {
            color: var(--text-sidebar);
            background-color: var(--border-light);
        }
        
        .card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-md);
        }
        
        .card-header {
            background-color: var(--bg-card);
            border-bottom: 1px solid var(--border-color);
        }
        
        .table {
            color: var(--text-primary);
        }
        
        .table thead th {
            background-color: var(--border-light);
            color: var(--text-primary);
            border-color: var(--border-color);
            transition: all 0.2s ease;
        }
        
        .table thead th:hover {
            background-color: var(--table-header-hover-bg);
            color: var(--table-header-hover-text);
            border-bottom: 1px solid var(--table-header-hover-border);
        }
        
        .table thead th .sort-icon {
            color: var(--table-sort-icon);
            transition: color 0.2s ease;
        }
        
        .table thead th:hover .sort-icon {
            color: var(--table-sort-icon-hover);
        }
        
        .table tbody tr:nth-child(even) {
            background-color: var(--border-light);
        }
        
        .table tbody td {
            border-color: var(--border-color);
        }
        
        .btn {
            transition: all 0.2s ease;
        }
        
        .btn-primary {
            background-color: var(--accent-primary);
            border-color: var(--accent-primary);
        }
        
        .btn-success {
            background-color: var(--accent-success);
            border-color: var(--accent-success);
        }
        
        .btn-warning {
            background-color: var(--accent-warning);
            border-color: var(--accent-warning);
        }
        
        .btn-danger {
            background-color: var(--accent-danger);
            border-color: var(--accent-danger);
        }
        
        .badge {
            transition: all 0.2s ease;
        }
        
        .alert {
            border: 1px solid var(--border-color);
        }
        
        .alert-success {
            background-color: rgba(16, 185, 129, 0.1);
            border-color: var(--accent-success);
            color: var(--accent-success);
        }
        
        .alert-danger {
            background-color: rgba(239, 68, 68, 0.1);
            border-color: var(--accent-danger);
            color: var(--accent-danger);
        }
        
        .form-control {
            background-color: var(--bg-card);
            border-color: var(--border-color);
            color: var(--text-primary);
        }
        
        .form-control:focus {
            background-color: var(--bg-card);
            border-color: var(--accent-primary);
            color: var(--text-primary);
        }
        
        .dropdown-menu {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-lg);
        }
        
        .dropdown-item {
            color: var(--text-primary);
        }
        
        .dropdown-item:hover {
            background-color: var(--border-light);
            color: var(--text-primary);
        }
        
        .breadcrumb {
            background-color: transparent;
        }
        
        .breadcrumb-item {
            color: var(--text-secondary);
        }
        
        .breadcrumb-item.active {
            color: var(--text-primary);
        }
        
        /* Футер */
        .main-footer {
            background-color: var(--bg-secondary);
            border-top: 1px solid var(--border-color);
            color: var(--text-primary);
        }
        
        /* Кнопка переключения темы */
        .theme-toggle {
            background: none;
            border: none;
            color: var(--text-primary);
            font-size: 18px;
            padding: 8px;
            border-radius: 6px;
            transition: all 0.2s ease;
            cursor: pointer;
        }
        
        .theme-toggle:hover {
            background-color: var(--border-light);
            transform: scale(1.1);
        }
        
        .theme-toggle:focus {
            outline: none;
            box-shadow: 0 0 0 2px var(--accent-primary);
        }
        
        /* Pagination styles */
        .pagination {
            --pagination-bg: #ffffff;
            --pagination-text: #374151;
            --pagination-border: #d1d5db;
            --pagination-active-bg: #3b82f6;
            --pagination-active-text: #ffffff;
            --pagination-arrow: #6b7280;
        }

        .dark .pagination {
            --pagination-bg: #1f2937;
            --pagination-text: #ffffff;
            --pagination-border: #374151;
            --pagination-active-bg: #3b82f6;
            --pagination-active-text: #ffffff;
            --pagination-arrow: #9ca3af;
        }

        .pagination .page-link {
            background-color: var(--pagination-bg);
            color: var(--pagination-text);
            border: 1px solid var(--pagination-border);
            border-radius: 4px;
            padding: 0.5rem 0.75rem;
            margin: 0 2px;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .pagination .page-link:hover {
            background-color: var(--pagination-bg);
            color: var(--pagination-text);
            border-color: var(--pagination-border);
            opacity: 0.8;
        }

        .pagination .page-item.active .page-link {
            background-color: var(--pagination-active-bg);
            color: var(--pagination-active-text);
            border-color: var(--pagination-active-bg);
        }

        .pagination .page-item.disabled .page-link {
            color: var(--pagination-arrow);
            background-color: var(--pagination-bg);
            border-color: var(--pagination-border);
        }

        .pagination .page-link:focus {
            box-shadow: none;
            outline: none;
        }
    </style>
    
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Header -->
        @include('admin.includes.header')

        <!-- Sidebar -->
        @include('admin.includes.sidebar')

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Content Header -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">@yield('page-title', 'Dashboard')</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                @yield('breadcrumbs')
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </section>
        </div>

        <!-- Footer -->
        @include('admin.includes.footer')
    </div>

    <!-- jQuery -->
    <script src="{{ asset('vendor/adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('vendor/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    <!-- DataTables -->
    <script src="{{ asset('vendor/adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>

    @stack('scripts')
    
    <script>
        // Система темизации
        class ThemeManager {
            constructor() {
                this.themeKey = 'admin-theme';
                this.init();
            }
            
            init() {
                // Тема уже применена инлайн-скриптом в <head>
                // Здесь только обновляем иконку кнопки и инициализируем обработчик
                const savedTheme = localStorage.getItem(this.themeKey) || 'light';
                this.updateToggleIcon(savedTheme);
                
                // Инициализируем кнопку переключения
                this.initToggleButton();
            }
            
            setTheme(theme) {
                const html = document.documentElement;
                
                if (theme === 'dark') {
                    html.classList.add('dark');
                } else {
                    html.classList.remove('dark');
                }
                
                // Сохраняем выбор
                localStorage.setItem(this.themeKey, theme);
                
                // Обновляем иконку кнопки
                this.updateToggleIcon(theme);
            }
            
            toggleTheme() {
                const currentTheme = localStorage.getItem(this.themeKey) || 'light';
                const newTheme = currentTheme === 'light' ? 'dark' : 'light';
                this.setTheme(newTheme);
            }
            
            initToggleButton() {
                const toggleBtn = document.getElementById('theme-toggle');
                if (toggleBtn) {
                    toggleBtn.addEventListener('click', () => {
                        this.toggleTheme();
                    });
                }
            }
            
            updateToggleIcon(theme) {
                const toggleBtn = document.getElementById('theme-toggle');
                if (toggleBtn) {
                    const icon = toggleBtn.querySelector('i');
                    if (icon) {
                        if (theme === 'dark') {
                            icon.className = 'fas fa-sun';
                        } else {
                            icon.className = 'fas fa-moon';
                        }
                    }
                }
            }
        }
        
        // Стандартная инициализация AdminLTE
        $(function () {
            // Инициализируем систему темизации
            new ThemeManager();
            
            // Закрытие уведомлений
            $('.alert .close').on('click', function() {
                $(this).closest('.alert').fadeOut(300, function() {
                    $(this).remove();
                });
            });
            
            // Автозакрытие уведомлений через 5 сек
            setTimeout(function() {
                $('.alert').fadeOut(300, function() {
                    $(this).remove();
                });
            }, 5000);
            
            // Выпадающие меню
            $('[data-toggle="dropdown"]').dropdown();
        });
    </script>
</body>
</html>





