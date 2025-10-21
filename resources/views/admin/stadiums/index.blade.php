@extends('admin.layouts.app')

@section('title', 'Стадионы')
@section('page-title', 'Управление стадионами')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Стадионы</li>
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
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-list"></i>
                        Список стадионов
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.stadiums.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i>
                            Создать стадион
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Фильтры и поиск -->
                    <form method="GET" action="{{ route('admin.stadiums.index') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="name">Поиск по названию</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-search"></i>
                                            </span>
                                        </div>
                                        <input type="text"
                                               class="form-control"
                                               id="name"
                                               name="name"
                                               value="{{ request('name') }}"
                                               placeholder="Введите название стадиона...">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="capacity_min">Вместимость от</label>
                                    <input type="number"
                                           class="form-control"
                                           id="capacity_min"
                                           name="capacity_min"
                                           value="{{ request('capacity_min') }}"
                                           placeholder="0"
                                           min="1">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="capacity_max">Вместимость до</label>
                                    <input type="number"
                                           class="form-control"
                                           id="capacity_max"
                                           name="capacity_max"
                                           value="{{ request('capacity_max') }}"
                                           placeholder="100000"
                                           min="1">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="per_page">На странице</label>
                                    <select class="form-control" id="per_page" name="per_page">
                                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                        <option value="15" {{ request('per_page') == 15 ? 'selected' : '' }}>15</option>
                                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <div class="btn-group d-block">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search"></i>
                                            Поиск
                                        </button>
                                        <a href="{{ route('admin.stadiums.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-times"></i>
                                            Очистить
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Таблица стадионов -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>
                                        <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'id', 'sort_direction' => request('sort_direction') == 'asc' ? 'desc' : 'asc']) }}"
                                           class="text-decoration-none">
                                            <i class="fas fa-sort"></i>
                                            # ID
                                        </a>
                                    </th>
                                    <th>
                                        <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'name', 'sort_direction' => request('sort_direction') == 'asc' ? 'desc' : 'asc']) }}"
                                           class="text-decoration-none">
                                            <i class="fas fa-sort"></i>
                                            Название
                                        </a>
                                    </th>
                                    <th>Адрес</th>
                                    <th>
                                        <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'total_capacity', 'sort_direction' => request('sort_direction') == 'asc' ? 'desc' : 'asc']) }}"
                                           class="text-decoration-none">
                                            <i class="fas fa-sort"></i>
                                            Вместимость
                                        </a>
                                    </th>
                                    <th>
                                        <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'created_at', 'sort_direction' => request('sort_direction') == 'asc' ? 'desc' : 'asc']) }}"
                                           class="text-decoration-none">
                                            <i class="fas fa-sort"></i>
                                            Дата создания
                                        </a>
                                    </th>
                                    <th width="200">Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($stadiums as $stadium)
                                    <tr>
                                        <td>{{ $stadium->id }}</td>
                                        <td>
                                            <strong>{{ $stadium->name }}</strong>
                                        </td>
                                        <td>{{ $stadium->address }}</td>
                                        <td>
                                            <span class="badge badge-info">
                                                <i class="fas fa-users"></i>
                                                {{ number_format($stadium->total_capacity) }}
                                            </span>
                                        </td>
                                        <td>{{ $stadium->created_at->format('d.m.Y H:i') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.stadiums.show', $stadium) }}"
                                                   class="btn btn-info btn-sm"
                                                   title="Просмотр">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.stadiums.edit', $stadium) }}"
                                                   class="btn btn-warning btn-sm"
                                                   title="Редактировать">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.stadiums.destroy', $stadium) }}"
                                                      method="POST"
                                                      class="d-inline"
                                                      onsubmit="return confirm('Вы уверены, что хотите удалить этот стадион?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="btn btn-danger btn-sm"
                                                            title="Удалить">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <i class="fas fa-info-circle fa-2x text-muted mb-2"></i>
                                            <p class="text-muted mb-0">Стадионы не найдены</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Пагинация -->
                    @if($stadiums->hasPages())
                        <div class="row mt-3">
                            <div class="col-sm-12 col-md-5">
                                <div class="dataTables_info">
                                    Показано {{ $stadiums->firstItem() }} - {{ $stadiums->lastItem() }} из {{ $stadiums->total() }} записей
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-7">
                                <div class="dataTables_paginate paging_simple_numbers">
                                    {{ $stadiums->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
