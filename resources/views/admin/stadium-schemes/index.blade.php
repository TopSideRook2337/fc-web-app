@extends('admin.layouts.app')

@section('title', 'Схемы стадионов')
@section('page-title', 'Управление схемами стадионов')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Схемы стадионов</li>
@endsection

@push('styles')
<style>
.schemes-card {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
}

.schemes-card-header {
    background: var(--card-bg);
    border-bottom: 1px solid var(--border-color);
    color: var(--text-primary);
    padding: 16px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.schemes-card-body {
    background: var(--card-bg);
    padding: 16px;
}

.schemes-table {
    width: 100%;
    color: var(--text-primary);
    background: transparent;
    border-collapse: collapse;
}

.schemes-table thead th {
    background: var(--card-bg);
    color: var(--text-primary);
    font-weight: 600;
    border-bottom: 1px solid var(--border-color);
    padding: 12px;
    text-align: left;
}

.schemes-table thead th i {
    color: #9CA3AF;
    margin-right: 0.5rem;
}

.schemes-table tbody tr {
    border-bottom: 1px solid #374151;
}

.schemes-table tbody td {
    padding: 12px;
    color: var(--text-primary);
    background: var(--card-bg);
}

.btn-primary {
    background-color: #3B82F6;
    border-color: #3B82F6;
    color: #FFFFFF;
    padding: 0.375rem 0.75rem;
    border-radius: 4px;
    text-decoration: none;
    display: inline-block;
    font-size: 0.875rem;
}

.btn-primary:hover {
    background-color: #2563EB;
    border-color: #2563EB;
    color: #FFFFFF;
    text-decoration: none;
}

.btn-info {
    background-color: #3B82F6;
    border-color: #3B82F6;
    color: #FFFFFF;
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
    border-radius: 4px;
    text-decoration: none;
    display: inline-block;
}

.btn-info:hover {
    background-color: #2563EB;
    border-color: #2563EB;
    color: #FFFFFF;
    text-decoration: none;
}

.btn-warning {
    background-color: #F59E0B;
    border-color: #F59E0B;
    color: #FFFFFF;
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
    border-radius: 4px;
    text-decoration: none;
    display: inline-block;
}

.btn-warning:hover {
    background-color: #D97706;
    border-color: #D97706;
    color: #FFFFFF;
    text-decoration: none;
}

.badge-info {
    background-color: #3B82F6;
    color: #FFFFFF;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    font-size: 0.875rem;
}

.text-muted {
    color: #9CA3AF !important;
}

.empty-state {
    text-align: center;
    padding: 3rem 0;
}

.empty-state i {
    color: #6B7280;
    margin-bottom: 1rem;
}

.empty-state h4 {
    color: #9CA3AF;
}

.empty-state p {
    color: #6B7280;
}
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="schemes-card">
            <div class="schemes-card-header">
                <h3 style="margin: 0; font-size: 1.25rem; font-weight: 600;">
                    <i class="fas fa-map" style="color: #9CA3AF; margin-right: 0.5rem;"></i>
                    Схемы стадионов
                </h3>
                <div>
                    <a href="{{ route('admin.stadium-schemes.upload') }}" class="btn-primary">
                        <i class="fas fa-plus" style="margin-right: 0.5rem;"></i>
                        Загрузить схему
                    </a>
                </div>
            </div>
            <div class="schemes-card-body">
                @if($stadiums->count() > 0)
                    <div style="overflow-x: auto;">
                        <table class="schemes-table">
                            <thead>
                                <tr>
                                    <th>
                                        <i class="fas fa-sort"></i>
                                        ID
                                    </th>
                                    <th>
                                        <i class="fas fa-sort"></i>
                                        Стадион
                                    </th>
                                    <th>
                                        <i class="fas fa-sort"></i>
                                        Адрес
                                    </th>
                                    <th>
                                        <i class="fas fa-sort"></i>
                                        Вместимость
                                    </th>
                                    <th>
                                        <i class="fas fa-sort"></i>
                                        Дата загрузки
                                    </th>
                                    <th style="width: 200px;">Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stadiums as $stadium)
                                <tr>
                                    <td>{{ $stadium->id }}</td>
                                    <td>
                                        <strong>{{ $stadium->name }}</strong>
                                    </td>
                                    <td>{{ $stadium->address }}</td>
                                    <td>
                                        <span class="badge-info">{{ number_format($stadium->total_capacity) }}</span>
                                    </td>
                                    <td>{{ $stadium->updated_at->format('d.m.Y H:i') }}</td>
                                    <td>
                                        <div style="display: flex; gap: 0.25rem;">
                                            <a href="{{ route('admin.stadium-schemes.preview', $stadium) }}" 
                                               class="btn-info" 
                                               title="Просмотр схемы">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.stadium-schemes.edit', $stadium) }}" 
                                               class="btn-warning" 
                                               title="Редактировать координаты">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1.5rem;">
                        <div>
                            <small class="text-muted">
                                Показано {{ $stadiums->firstItem() }} - {{ $stadiums->lastItem() }} 
                                из {{ $stadiums->total() }} записей
                            </small>
                        </div>
                        <div>
                            {{ $stadiums->links() }}
                        </div>
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-map fa-3x"></i>
                        <h4>Схемы стадионов не найдены</h4>
                        <p>Загрузите первую схему стадиона, чтобы начать работу.</p>
                        <a href="{{ route('admin.stadium-schemes.upload') }}" class="btn-primary" style="margin-top: 1rem;">
                            <i class="fas fa-plus" style="margin-right: 0.5rem;"></i>
                            Загрузить схему
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
