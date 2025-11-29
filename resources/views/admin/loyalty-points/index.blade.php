@extends('admin.layouts.app')

@section('title', 'Бонусные баллы')
@section('page-title', 'Управление бонусными баллами')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Бонусные баллы</li>
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
                    <h3 class="card-title">История начисления бонусов</h3>
                </div>
                <div class="card-body">
                    <!-- Фильтры -->
                    <form method="GET" action="{{ route('admin.loyalty-points.index') }}" id="filters-form">
                        <div class="row mb-3">
                            <div class="col-md-2">
                                <input type="date" class="form-control" name="date_from" value="{{ request('date_from') }}" placeholder="Дата от">
                            </div>
                            <div class="col-md-2">
                                <input type="date" class="form-control" name="date_to" value="{{ request('date_to') }}" placeholder="Дата до">
                            </div>
                            <div class="col-md-2">
                                <input type="number" class="form-control" name="user_id" value="{{ request('user_id') }}" placeholder="ID пользователя">
                            </div>
                            <div class="col-md-2">
                                <input type="number" class="form-control" name="order_id" value="{{ request('order_id') }}" placeholder="ID заказа">
                            </div>
                            <div class="col-md-2">
                                <select class="form-control" name="per_page" id="per-page-select">
                                    <option value="15" {{ request('per_page') == 15 ? 'selected' : '' }}>15 на странице</option>
                                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 на странице</option>
                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 на странице</option>
                                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 на странице</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fa fa-search"></i> Поиск
                                </button>
                                <a href="{{ route('admin.loyalty-points.index') }}" class="btn btn-secondary btn-sm">
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
                                    <th class="sortable" data-sort="user_id">
                                        <i class="fa fa-user"></i> Пользователь
                                        @if(request('sort_by') == 'user_id')
                                            <i class="fa fa-sort-{{ request('sort_direction') == 'asc' ? 'up' : 'down' }}"></i>
                                        @else
                                            <i class="fa fa-sort text-muted"></i>
                                        @endif
                                    </th>
                                    <th class="sortable" data-sort="points">
                                        <i class="fa fa-coins"></i> Баллы
                                        @if(request('sort_by') == 'points')
                                            <i class="fa fa-sort-{{ request('sort_direction') == 'asc' ? 'up' : 'down' }}"></i>
                                        @else
                                            <i class="fa fa-sort text-muted"></i>
                                        @endif
                                    </th>
                                    <th><i class="fa fa-info-circle"></i> Причина</th>
                                    <th><i class="fa fa-shopping-cart"></i> Заказ</th>
                                    <th class="sortable" data-sort="created_at">
                                        <i class="fa fa-calendar"></i> Дата начисления
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
                                @forelse($loyaltyPoints as $point)
                                    <tr>
                                        <td>{{ $point->id }}</td>
                                        <td>
                                            @if($point->user)
                                                <a href="{{ route('admin.users.show', $point->user) }}">
                                                    {{ $point->user->name }}
                                                </a>
                                                <br><small class="text-muted">{{ $point->user->email }}</small>
                                            @else
                                                <span class="text-muted">Не указан</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-success" style="font-size: 1rem;">
                                                <i class="fa fa-plus"></i> {{ $point->points }}
                                            </span>
                                        </td>
                                        <td>{{ $point->reason ?? 'Не указана' }}</td>
                                        <td>
                                            @if($point->order)
                                                <a href="{{ route('admin.orders.show', $point->order) }}" class="btn btn-sm btn-info">
                                                    <i class="fa fa-eye"></i> Заказ #{{ $point->order->id }}
                                                </a>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td>{{ $point->created_at ? $point->created_at->format('d.m.Y H:i') : 'Не указано' }}</td>
                                        <td>
                                            <a href="{{ route('admin.loyalty-points.show', $point) }}" 
                                               class="btn btn-info btn-sm" 
                                               title="Просмотр"
                                               data-bs-toggle="tooltip">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">Записи не найдены</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Информация о записях -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="text-muted mb-0">
                                Показано {{ $loyaltyPoints->firstItem() ?? 0 }} - {{ $loyaltyPoints->lastItem() ?? 0 }} 
                                из {{ $loyaltyPoints->total() }} записей
                            </p>
                        </div>
                        <div class="col-md-6 text-right">
                            <p class="text-muted mb-0">
                                Страница {{ $loyaltyPoints->currentPage() }} из {{ $loyaltyPoints->lastPage() }}
                            </p>
                        </div>
                    </div>

                    <!-- Пагинация -->
                    <div class="d-flex justify-content-center">
                        <nav aria-label="Навигация по страницам">
                            {{ $loyaltyPoints->links('pagination::bootstrap-4') }}
                        </nav>
                    </div>
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

    // Инициализация tooltips
    document.addEventListener('DOMContentLoaded', function() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush







