@extends('admin.layouts.app')

@section('title', 'Матчи')
@section('page-title', 'Управление матчами')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Матчи</li>
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
.team-logo {
    width: 30px;
    height: 30px;
    object-fit: cover;
    border-radius: 50%;
}
</style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Список матчей</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.games.create') }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-plus-circle"></i> Создать матч
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Фильтры -->
                    <form method="GET" action="{{ route('admin.games.index') }}" id="filters-form">
                        <div class="row mb-3">
                            <div class="col-md-2">
                                <select class="form-control" name="status" id="status-filter">
                                    <option value="">Все статусы</option>
                                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Черновик</option>
                                    <option value="ready" {{ request('status') == 'ready' ? 'selected' : '' }}>Готов</option>
                                    <option value="tickets_open" {{ request('status') == 'tickets_open' ? 'selected' : '' }}>Продажи открыты</option>
                                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Завершен</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Отменен</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select class="form-control" name="stadium_id" id="stadium-filter">
                                    <option value="">Все стадионы</option>
                                    @foreach($stadiums as $stadium)
                                        <option value="{{ $stadium->id }}" {{ request('stadium_id') == $stadium->id ? 'selected' : '' }}>
                                            {{ $stadium->name }}
                                        </option>
                                    @endforeach
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
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fa fa-search"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" name="title" value="{{ request('title') }}" placeholder="Поиск по названию матча...">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fa fa-search"></i> Поиск
                                </button>
                                <a href="{{ route('admin.games.index') }}" class="btn btn-secondary btn-sm">
                                    <i class="fa fa-times"></i> Очистить
                                </a>
                            </div>
                        </div>
                        <!-- Скрытые поля для сортировки -->
                        <input type="hidden" name="sort_by" value="{{ request('sort_by', 'start_at') }}">
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
                                    <th class="sortable" data-sort="title">
                                        <i class="fa fa-trophy"></i> Название
                                        @if(request('sort_by') == 'title')
                                            <i class="fa fa-sort-{{ request('sort_direction') == 'asc' ? 'up' : 'down' }}"></i>
                                        @else
                                            <i class="fa fa-sort text-muted"></i>
                                        @endif
                                    </th>
                                    <th>
                                        <i class="fa fa-users"></i> Команды
                                    </th>
                                    <th class="sortable" data-sort="start_at">
                                        <i class="fa fa-calendar"></i> Дата матча
                                        @if(request('sort_by') == 'start_at')
                                            <i class="fa fa-sort-{{ request('sort_direction') == 'asc' ? 'up' : 'down' }}"></i>
                                        @else
                                            <i class="fa fa-sort text-muted"></i>
                                        @endif
                                    </th>
                                    <th class="sortable" data-sort="stadium_id">
                                        <i class="fa fa-building"></i> Стадион
                                        @if(request('sort_by') == 'stadium_id')
                                            <i class="fa fa-sort-{{ request('sort_direction') == 'asc' ? 'up' : 'down' }}"></i>
                                        @else
                                            <i class="fa fa-sort text-muted"></i>
                                        @endif
                                    </th>
                                    <th class="sortable" data-sort="tickets_available">
                                        <i class="fa fa-ticket-alt"></i> Продажи
                                        @if(request('sort_by') == 'tickets_available')
                                            <i class="fa fa-sort-{{ request('sort_direction') == 'asc' ? 'up' : 'down' }}"></i>
                                        @else
                                            <i class="fa fa-sort text-muted"></i>
                                        @endif
                                    </th>
                                    <th><i class="fa fa-cogs"></i> Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($games as $game)
                                    <tr>
                                        <td>{{ $game->id }}</td>
                                        <td>
                                            <strong>{{ $game->title }}</strong>
                                        </td>
                                        <td>
                                        <div class="d-flex align-items-center">
                                            @if($game->home_team_logo_path)
                                                <img src="{{ asset('storage/' . $game->home_team_logo_path) }}" alt="{{ $game->home_team_name }}" class="team-logo me-2">
                                            @else
                                                <div class="team-logo me-2 bg-light d-flex align-items-center justify-content-center">
                                                    <i class="fa fa-user text-muted"></i>
                                                </div>
                                            @endif
                                            <span class="me-2">{{ $game->home_team_name }}</span>
                                            <span class="text-muted">vs</span>
                                            <span class="ms-2 me-2">{{ $game->away_team_name }}</span>
                                            @if($game->away_team_logo_path)
                                                <img src="{{ asset('storage/' . $game->away_team_logo_path) }}" alt="{{ $game->away_team_name }}" class="team-logo">
                                            @else
                                                <div class="team-logo bg-light d-flex align-items-center justify-content-center">
                                                    <i class="fa fa-user text-muted"></i>
                                                </div>
                                            @endif
                                        </div>
                                        </td>
                                        <td>
                                            <strong>{{ $game->start_at ? $game->start_at->format('d.m.Y H:i') : 'Не указано' }}</strong>
                                            @if($game->start_at && $game->start_at->isFuture())
                                                <br><small class="text-success">Предстоящий</small>
                                            @elseif($game->start_at && $game->start_at->isPast())
                                                <br><small class="text-muted">Прошедший</small>
                                            @endif
                                        </td>
                                        <td>{{ $game->stadium->name ?? 'Не указан' }}</td>
                                        <td>
                                            @php
                                                $statusLabels = [
                                                    'draft' => ['label' => 'Черновик', 'class' => 'secondary'],
                                                    'ready' => ['label' => 'Готов', 'class' => 'info'],
                                                    'tickets_open' => ['label' => 'Продажи открыты', 'class' => 'success'],
                                                    'completed' => ['label' => 'Завершен', 'class' => 'primary'],
                                                    'cancelled' => ['label' => 'Отменен', 'class' => 'danger']
                                                ];
                                                $status = $statusLabels[$game->status] ?? ['label' => $game->status, 'class' => 'secondary'];
                                            @endphp
                                            <span class="badge badge-{{ $status['class'] }}">
                                                {{ $status['label'] }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Действия">
                                                <a href="{{ route('admin.games.show', $game) }}" 
                                                   class="btn btn-info btn-sm" 
                                                   title="Просмотр"
                                                   data-bs-toggle="tooltip">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.games.edit', $game) }}" 
                                                   class="btn btn-warning btn-sm" 
                                                   title="Редактировать"
                                                   data-bs-toggle="tooltip">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-danger btn-sm" 
                                                        title="Удалить"
                                                        data-bs-toggle="tooltip"
                                                        onclick="confirmDelete('{{ route('admin.games.destroy', $game) }}', '{{ $game->title }}')">
                                                    <i class="fa fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">Матчи не найдены</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Информация о записях -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="text-muted mb-0">
                                Показано {{ $games->firstItem() ?? 0 }} - {{ $games->lastItem() ?? 0 }} 
                                из {{ $games->total() }} записей
                            </p>
                        </div>
                        <div class="col-md-6 text-right">
                            <p class="text-muted mb-0">
                                Страница {{ $games->currentPage() }} из {{ $games->lastPage() }}
                            </p>
                        </div>
                    </div>

                    <!-- Пагинация -->
                    <div class="d-flex justify-content-center">
                        <nav aria-label="Навигация по страницам">
                            {{ $games->links('pagination::bootstrap-4') }}
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

    // Функция подтверждения удаления
    function confirmDelete(url, title) {
        if (confirm(`Вы уверены, что хотите удалить матч "${title}"?`)) {
            // Создаем скрытую форму для отправки DELETE запроса
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = url;
            
            // Добавляем CSRF токен
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            form.appendChild(csrfToken);
            
            // Добавляем метод DELETE
            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'DELETE';
            form.appendChild(methodField);
            
            // Добавляем форму в DOM и отправляем
            document.body.appendChild(form);
            form.submit();
        }
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
