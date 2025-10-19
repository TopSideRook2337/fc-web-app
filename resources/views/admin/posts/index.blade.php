@extends('admin.layouts.app')

@section('title', 'Новости')
@section('page-title', 'Управление новостями')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Новости</li>
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
                    <h3 class="card-title">Список новостей</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.posts.create') }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-plus-circle"></i> Создать новость
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Фильтры -->
                    <form method="GET" action="{{ route('admin.posts.index') }}" id="filters-form">
                        <div class="row mb-3">
                            <div class="col-md-2">
                                <select class="form-control" name="status" id="status-filter">
                                    <option value="">Все статусы</option>
                                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Черновик</option>
                                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Опубликовано</option>
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
                                    <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Поиск по заголовку или содержанию...">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fa fa-search"></i> Поиск
                                </button>
                                <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary btn-sm">
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
                                    <th class="sortable" data-sort="title">
                                        <i class="fa fa-file-text"></i> Заголовок
                                        @if(request('sort_by') == 'title')
                                            <i class="fa fa-sort-{{ request('sort_direction') == 'asc' ? 'up' : 'down' }}"></i>
                                        @else
                                            <i class="fa fa-sort text-muted"></i>
                                        @endif
                                    </th>
                                    <th class="sortable" data-sort="status">
                                        <i class="fa fa-flag"></i> Статус
                                        @if(request('sort_by') == 'status')
                                            <i class="fa fa-sort-{{ request('sort_direction') == 'asc' ? 'up' : 'down' }}"></i>
                                        @else
                                            <i class="fa fa-sort text-muted"></i>
                                        @endif
                                    </th>
                                    <th class="sortable" data-sort="author_name">
                                        <i class="fa fa-user"></i> Автор
                                        @if(request('sort_by') == 'author_name')
                                            <i class="fa fa-sort-{{ request('sort_direction') == 'asc' ? 'up' : 'down' }}"></i>
                                        @else
                                            <i class="fa fa-sort text-muted"></i>
                                        @endif
                                    </th>
                                    <th class="sortable" data-sort="created_at">
                                        <i class="fa fa-calendar-plus"></i> Дата создания
                                        @if(request('sort_by') == 'created_at')
                                            <i class="fa fa-sort-{{ request('sort_direction') == 'asc' ? 'up' : 'down' }}"></i>
                                        @else
                                            <i class="fa fa-sort text-muted"></i>
                                        @endif
                                    </th>
                                    <th class="sortable" data-sort="published_at">
                                        <i class="fa fa-calendar-check"></i> Дата публикации
                                        @if(request('sort_by') == 'published_at')
                                            <i class="fa fa-sort-{{ request('sort_direction') == 'asc' ? 'up' : 'down' }}"></i>
                                        @else
                                            <i class="fa fa-sort text-muted"></i>
                                        @endif
                                    </th>
                                    <th><i class="fa fa-cogs"></i> Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($posts as $post)
                                    <tr>
                                        <td>{{ $post->id }}</td>
                                        <td>
                                            <strong>{{ $post->title }}</strong>
                                            @if($post->excerpt)
                                                <br><small class="text-muted">{{ Str::limit($post->excerpt, 100) }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $post->status === 'published' ? 'success' : 'warning' }}">
                                                <i class="fa fa-{{ $post->status === 'published' ? 'check-circle' : 'edit' }}"></i>
                                                {{ $post->status === 'published' ? 'Опубликовано' : 'Черновик' }}
                                            </span>
                                        </td>
                                        <td>{{ $post->author_name ?? 'Не указан' }}</td>
                                        <td>{{ $post->created_at ? $post->created_at->format('d.m.Y H:i') : 'Не указано' }}</td>
                                        <td>{{ $post->published_at ? $post->published_at->format('d.m.Y H:i') : '-' }}</td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Действия">
                                                <a href="{{ route('admin.posts.show', $post) }}" 
                                                   class="btn btn-info btn-sm" 
                                                   title="Просмотр"
                                                   data-bs-toggle="tooltip">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.posts.edit', $post) }}" 
                                                   class="btn btn-warning btn-sm" 
                                                   title="Редактировать"
                                                   data-bs-toggle="tooltip">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-danger btn-sm" 
                                                        title="Удалить"
                                                        data-bs-toggle="tooltip"
                                                        onclick="confirmDelete('{{ route('admin.posts.destroy', $post) }}', '{{ $post->title }}')">
                                                    <i class="fa fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">Новости не найдены</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Информация о записях -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="text-muted mb-0">
                                Показано {{ $posts->firstItem() ?? 0 }} - {{ $posts->lastItem() ?? 0 }} 
                                из {{ $posts->total() }} записей
                            </p>
                        </div>
                        <div class="col-md-6 text-right">
                            <p class="text-muted mb-0">
                                Страница {{ $posts->currentPage() }} из {{ $posts->lastPage() }}
                            </p>
                        </div>
                    </div>

                    <!-- Пагинация -->
                    <div class="d-flex justify-content-center">
                        <nav aria-label="Навигация по страницам">
                            {{ $posts->links('pagination::bootstrap-4') }}
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
        if (confirm(`Вы уверены, что хотите удалить новость "${title}"?`)) {
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

