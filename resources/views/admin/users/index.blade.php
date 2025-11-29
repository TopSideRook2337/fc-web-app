@extends('admin.layouts.app')

@section('title', 'Пользователи')
@section('page-title', 'Управление пользователями')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Пользователи</li>
@endsection

@push('styles')
<style>
.btn-group .btn {
    margin-right: 2px;
}
.btn-group .btn:last-child {
    margin-right: 0;
}
.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}
.btn i {
    margin-right: 0.25rem;
}
.btn-sm i {
    margin-right: 0;
}
.table th i {
    margin-right: 0.5rem;
    color: #6c757d;
}
.input-group-text i {
    color: #6c757d;
}
.badge i {
    margin-right: 0.25rem;
}
.pagination {
    margin-bottom: 0;
}
.pagination .page-link {
    color: #007bff;
    border-color: #dee2e6;
}
.pagination .page-item.active .page-link {
    background-color: #007bff;
    border-color: #007bff;
}
.pagination .page-link:hover {
    color: #0056b3;
    background-color: #e9ecef;
    border-color: #dee2e6;
}
.pagination .page-item.disabled .page-link {
    color: #6c757d;
    background-color: #fff;
    border-color: #dee2e6;
}
.sortable {
    cursor: pointer;
    user-select: none;
    position: relative;
}
.sortable:hover {
    background-color: #f8f9fa;
}
.sortable i.fa-sort {
    opacity: 0.3;
}
.sortable:hover i.fa-sort {
    opacity: 0.7;
}
</style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Список пользователей</h3>
                    @if(auth()->user()->role === 'admin')
                    <div class="card-tools">
                        <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-plus-circle"></i> Создать пользователя
                        </a>
                    </div>
                    @endif
                </div>
                <div class="card-body">
                    <!-- Фильтры -->
                    <form method="GET" action="{{ route('admin.users.index') }}" id="filters-form">
                        <div class="row mb-3">
                            <div class="col-md-2">
                                <select class="form-control" name="role" id="role-filter">
                                    <option value="">Все роли</option>
                                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Администратор</option>
                                    <option value="manager" {{ request('role') == 'manager' ? 'selected' : '' }}>Менеджер</option>
                                    <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>Пользователь</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select class="form-control" name="per_page" id="per-page-select">
                                    <option value="15" {{ request('per_page') == 15 ? 'selected' : '' }}>15 на странице</option>
                                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 на странице</option>
                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 на странице</option>
                                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 на странице</option>
                                </select>
                            </div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fa fa-search"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Поиск по имени или email...">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fa fa-search"></i> Поиск
                                </button>
                                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">
                                    <i class="fa fa-times"></i> Очистить
                                </a>
                            </div>
                        </div>
                        <!-- Скрытые поля для сортировки -->
                        <input type="hidden" name="sort_by" value="{{ request('sort_by', 'created_at') }}">
                        <input type="hidden" name="sort_direction" value="{{ request('sort_direction', 'desc') }}">
                    </form>

                    <!-- Таблица -->
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="sortable" data-sort="id">
                                        <i class="fa fa-hashtag"></i> ID
                                        @if(request('sort_by') == 'id')
                                            <i class="fa fa-sort-{{ request('sort_direction') == 'asc' ? 'up' : 'down' }}"></i>
                                        @else
                                            <i class="fa fa-sort text-muted"></i>
                                        @endif
                                    </th>
                                    <th class="sortable" data-sort="name">
                                        <i class="fa fa-user"></i> Имя
                                        @if(request('sort_by') == 'name')
                                            <i class="fa fa-sort-{{ request('sort_direction') == 'asc' ? 'up' : 'down' }}"></i>
                                        @else
                                            <i class="fa fa-sort text-muted"></i>
                                        @endif
                                    </th>
                                    <th class="sortable" data-sort="email">
                                        <i class="fa fa-envelope"></i> Email
                                        @if(request('sort_by') == 'email')
                                            <i class="fa fa-sort-{{ request('sort_direction') == 'asc' ? 'up' : 'down' }}"></i>
                                        @else
                                            <i class="fa fa-sort text-muted"></i>
                                        @endif
                                    </th>
                                    <th class="sortable" data-sort="role">
                                        <i class="fa fa-user-tag"></i> Роль
                                        @if(request('sort_by') == 'role')
                                            <i class="fa fa-sort-{{ request('sort_direction') == 'asc' ? 'up' : 'down' }}"></i>
                                        @else
                                            <i class="fa fa-sort text-muted"></i>
                                        @endif
                                    </th>
                                    <th class="sortable" data-sort="created_at">
                                        <i class="fa fa-calendar-plus"></i> Дата регистрации
                                        @if(request('sort_by') == 'created_at')
                                            <i class="fa fa-sort-{{ request('sort_direction') == 'asc' ? 'up' : 'down' }}"></i>
                                        @else
                                            <i class="fa fa-sort text-muted"></i>
                                        @endif
                                    </th>
                                    <th><i class="fa fa-cogs"></i> Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td><strong>{{ $user->name }}</strong></td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @php
                                                $roleConfig = [
                                                    'admin' => ['badge' => 'danger', 'icon' => 'user-shield', 'label' => 'Администратор'],
                                                    'manager' => ['badge' => 'warning', 'icon' => 'user-tie', 'label' => 'Менеджер'],
                                                    'user' => ['badge' => 'info', 'icon' => 'user', 'label' => 'Пользователь'],
                                                ];
                                                $config = $roleConfig[$user->role] ?? ['badge' => 'secondary', 'icon' => 'user', 'label' => 'Неизвестно'];
                                            @endphp
                                            <span class="badge badge-{{ $config['badge'] }}">
                                                <i class="fa fa-{{ $config['icon'] }}"></i>
                                                {{ $config['label'] }}
                                            </span>
                                        </td>
                                        <td>{{ $user->created_at ? $user->created_at->format('d.m.Y H:i') : 'Не указано' }}</td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Действия">
                                                <a href="{{ route('admin.users.show', $user) }}" 
                                                   class="btn btn-info btn-sm" 
                                                   title="Просмотр"
                                                   data-bs-toggle="tooltip">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                @if(auth()->user()->role === 'admin')
                                                <a href="{{ route('admin.users.edit', $user) }}" 
                                                   class="btn btn-warning btn-sm" 
                                                   title="Редактировать"
                                                   data-bs-toggle="tooltip">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                @if($user->id !== auth()->id())
                                                <button type="button" 
                                                        class="btn btn-danger btn-sm" 
                                                        title="Удалить"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal"
                                                        onclick="setDeleteForm('{{ route('admin.users.destroy', $user) }}', '{{ $user->name }}')">
                                                    <i class="fa fa-trash-alt"></i>
                                                </button>
                                                @endif
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">Пользователи не найдены</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Информация о записях -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="text-muted mb-0">
                                Показано {{ $users->firstItem() ?? 0 }} - {{ $users->lastItem() ?? 0 }} 
                                из {{ $users->total() }} записей
                            </p>
                        </div>
                        <div class="col-md-6 text-right">
                            <p class="text-muted mb-0">
                                Страница {{ $users->currentPage() }} из {{ $users->lastPage() }}
                            </p>
                        </div>
                    </div>

                    <!-- Пагинация -->
                    <div class="d-flex justify-content-center">
                        <nav aria-label="Навигация по страницам">
                            {{ $users->links('pagination::bootstrap-4') }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Модальное окно подтверждения удаления -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Подтверждение удаления</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Вы уверены, что хотите удалить пользователя <strong id="deleteUserName"></strong>?</p>
                    <p class="text-danger"><small>Это действие необратимо!</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                    <form id="deleteForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Удалить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Обработка изменения количества записей на странице
    document.getElementById('per-page-select').addEventListener('change', function() {
        document.getElementById('filters-form').submit();
    });

    // Обработка изменения фильтра роли
    document.getElementById('role-filter').addEventListener('change', function() {
        document.getElementById('filters-form').submit();
    });

    // Обработка сортировки по заголовкам
    document.querySelectorAll('.sortable').forEach(header => {
        header.addEventListener('click', function() {
            const sortBy = this.dataset.sort;
            const currentSort = document.querySelector('input[name="sort_by"]').value;
            const currentDirection = document.querySelector('input[name="sort_direction"]').value;
            
            let newDirection = 'asc';
            if (currentSort === sortBy && currentDirection === 'asc') {
                newDirection = 'desc';
            }
            
            document.querySelector('input[name="sort_by"]').value = sortBy;
            document.querySelector('input[name="sort_direction"]').value = newDirection;
            document.getElementById('filters-form').submit();
        });
    });

    // Функция установки данных в модальное окно удаления
    function setDeleteForm(url, userName) {
        document.getElementById('deleteForm').action = url;
        document.getElementById('deleteUserName').textContent = userName;
    }

    // Инициализация tooltips
    document.addEventListener('DOMContentLoaded', function() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush







