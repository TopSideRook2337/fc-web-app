@extends('admin.layouts.app')

@section('title', 'Просмотр схемы стадиона')
@section('page-title', 'Просмотр схемы стадиона')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.stadium-schemes.index') }}">Схемы стадионов</a></li>
    <li class="breadcrumb-item active">{{ $stadium->name }}</li>
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

.schemes-card-footer {
    background: var(--card-bg);
    border-top: 1px solid var(--border-color);
    padding: 16px;
}

.scheme-container {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
}

.scheme-container h5 {
    color: var(--text-primary);
    font-weight: 600;
    margin-bottom: 1rem;
}

.scheme-container h5 i {
    color: #9CA3AF;
    margin-right: 0.5rem;
}

.info-table {
    width: 100%;
    color: var(--text-primary);
}

.info-table td {
    padding: 0.5rem 0;
    border-bottom: 1px solid #374151;
}

.info-table td:first-child {
    font-weight: 600;
    width: 50%;
}

.badge-info {
    background-color: #3B82F6;
    color: #FFFFFF;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    font-size: 0.875rem;
}

.badge-secondary {
    background-color: #4B5563;
    color: #FFFFFF;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    font-size: 0.875rem;
}

.coords-table {
    width: 100%;
    color: var(--text-primary);
    background: transparent;
    border-collapse: collapse;
}

.coords-table thead th {
    background: var(--card-bg);
    color: var(--text-primary);
    font-weight: 600;
    border-bottom: 1px solid var(--border-color);
    padding: 8px;
    text-align: left;
}

.coords-table tbody tr {
    border-bottom: 1px solid #374151;
}

.coords-table tbody td {
    padding: 8px;
    color: var(--text-primary);
    background: var(--card-bg);
}

.btn-secondary {
    background-color: #6B7280;
    border-color: #6B7280;
    color: #FFFFFF;
    padding: 0.5rem 1rem;
    border-radius: 4px;
    text-decoration: none;
    display: inline-block;
}

.btn-secondary:hover {
    background-color: #4B5563;
    border-color: #4B5563;
    color: #FFFFFF;
    text-decoration: none;
}

.btn-warning {
    background-color: #F59E0B;
    border-color: #F59E0B;
    color: #FFFFFF;
    padding: 0.5rem 1rem;
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

.text-muted {
    color: #9CA3AF !important;
}

.empty-state {
    text-align: center;
    padding: 2rem 0;
}

.empty-state i {
    color: #6B7280;
    margin-bottom: 1rem;
}

.empty-state h5 {
    color: #9CA3AF;
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
                    {{ $stadium->name }}
                </h3>
                <div>
                    <a href="{{ route('admin.stadium-schemes.edit', $stadium) }}" class="btn-warning" style="font-size: 0.875rem;">
                        <i class="fas fa-edit" style="margin-right: 0.5rem;"></i>
                        Редактировать координаты
                    </a>
                </div>
            </div>
            <div class="schemes-card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="scheme-container">
                            <h5>
                                <i class="fas fa-image"></i>
                                SVG Схема стадиона
                            </h5>
                            
                            @if($stadium->schema_svg_path)
                                <div class="svg-preview" style="max-width: 100%; overflow: auto;">
                                    <object data="{{ asset('storage/' . $stadium->schema_svg_path) }}" 
                                            type="image/svg+xml" 
                                            style="width: 100%; height: auto; min-height: 400px;">
                                        <img src="{{ asset('storage/' . $stadium->schema_svg_path) }}" 
                                             alt="Схема стадиона {{ $stadium->name }}" 
                                             style="width: 100%; height: auto;">
                                    </object>
                                </div>
                            @else
                                <div class="empty-state">
                                    <i class="fas fa-image fa-3x"></i>
                                    <h5>Схема не загружена</h5>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="schemes-card" style="margin-bottom: 1rem;">
                            <div class="schemes-card-header">
                                <h3 style="margin: 0; font-size: 1rem; font-weight: 600;">
                                    <i class="fas fa-info-circle" style="color: #9CA3AF; margin-right: 0.5rem;"></i>
                                    Информация о стадионе
                                </h3>
                            </div>
                            <div class="schemes-card-body">
                                <table class="info-table">
                                    <tr>
                                        <td>ID:</td>
                                        <td>{{ $stadium->id }}</td>
                                    </tr>
                                    <tr>
                                        <td>Название:</td>
                                        <td>{{ $stadium->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Адрес:</td>
                                        <td>{{ $stadium->address }}</td>
                                    </tr>
                                    <tr>
                                        <td>Вместимость:</td>
                                        <td>
                                            <span class="badge-info">{{ number_format($stadium->total_capacity) }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Дата загрузки:</td>
                                        <td>{{ $stadium->updated_at->format('d.m.Y H:i') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        @if($stadium->sector_coordinates)
                        <div class="schemes-card">
                            <div class="schemes-card-header">
                                <h3 style="margin: 0; font-size: 1rem; font-weight: 600;">
                                    <i class="fas fa-map-marker-alt" style="color: #9CA3AF; margin-right: 0.5rem;"></i>
                                    Координаты секторов
                                </h3>
                            </div>
                            <div class="schemes-card-body">
                                @php
                                    $coordinates = json_decode($stadium->sector_coordinates, true);
                                @endphp
                                
                                @if($coordinates && count($coordinates) > 0)
                                    <div style="overflow-x: auto;">
                                        <table class="coords-table">
                                            <thead>
                                                <tr>
                                                    <th>Сектор</th>
                                                    <th>X</th>
                                                    <th>Y</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($coordinates as $sectorId => $coords)
                                                <tr>
                                                    <td><span class="badge-secondary">{{ $sectorId }}</span></td>
                                                    <td>{{ $coords['x'] ?? '-' }}</td>
                                                    <td>{{ $coords['y'] ?? '-' }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="text-muted" style="margin-bottom: 0;">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        Координаты секторов не настроены
                                    </p>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="schemes-card-footer">
                <div style="display: flex; justify-content: space-between;">
                    <a href="{{ route('admin.stadium-schemes.index') }}" class="btn-secondary">
                        <i class="fas fa-arrow-left" style="margin-right: 0.5rem;"></i>
                        Назад к списку
                    </a>
                    <a href="{{ route('admin.stadium-schemes.edit', $stadium) }}" class="btn-warning">
                        <i class="fas fa-edit" style="margin-right: 0.5rem;"></i>
                        Редактировать координаты
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
