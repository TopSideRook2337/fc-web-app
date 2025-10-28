@extends('admin.layouts.app')

@section('title', 'Заказы')
@section('page-title', 'Управление заказами')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Заказы</li>
@endsection

@push('styles')
<style>
.status-badge {
    padding: 0.375rem 0.75rem;
    border-radius: 0.25rem;
    font-weight: 500;
    font-size: 0.875rem;
}
.status-cart { background-color: #4B5563; color: #FFFFFF; }
.status-pending { background-color: #D97706; color: #FFFFFF; }
.status-paid { background-color: #059669; color: #FFFFFF; }
.status-cancelled { background-color: #DC2626; color: #FFFFFF; }
.status-expired { background-color: #6B7280; color: #FFFFFF; }

.orders-card {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
}

.orders-card-header {
    background: var(--card-bg);
    border-bottom: 1px solid var(--border-color);
    color: var(--text-primary);
    padding: 16px;
}

.orders-card-body {
    background: var(--card-bg);
    padding: 16px;
}

.orders-table {
    width: 100%;
    color: var(--text-primary);
    background: transparent;
    border-collapse: collapse;
}

.orders-table thead th {
    background: var(--card-bg);
    color: var(--text-primary);
    font-weight: 600;
    border-bottom: 1px solid var(--border-color);
    padding: 12px;
    text-align: left;
}

.orders-table tbody tr {
    border-bottom: 1px solid #374151;
}

.orders-table tbody td {
    padding: 12px;
    color: var(--text-primary);
    background: var(--card-bg);
}

.form-control {
    background: var(--input-bg);
    border: 1px solid var(--border-color);
    color: var(--text-primary);
    border-radius: 4px;
    padding: 0.375rem 0.75rem;
}

.form-control:focus {
    background: var(--input-bg);
    border-color: #3B82F6;
    color: var(--text-primary);
    outline: none;
}

.btn-primary {
    background-color: #3B82F6;
    border-color: #3B82F6;
    color: #FFFFFF;
    padding: 0.375rem 0.75rem;
    border-radius: 4px;
    font-weight: 500;
}

.btn-primary:hover {
    background-color: #2563EB;
    border-color: #2563EB;
    color: #FFFFFF;
}

.btn-info {
    background-color: #3B82F6;
    border-color: #3B82F6;
    color: #FFFFFF;
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}

.btn-info:hover {
    background-color: #2563EB;
    border-color: #2563EB;
}

.btn-warning {
    background-color: #F59E0B;
    border-color: #F59E0B;
    color: #FFFFFF;
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}

.btn-warning:hover {
    background-color: #D97706;
    border-color: #D97706;
}

.text-muted {
    color: #9CA3AF !important;
}

.badge-info {
    background-color: #3B82F6;
    color: #FFFFFF;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    font-size: 0.875rem;
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
        <div class="orders-card">
            <div class="orders-card-header">
                <h3 style="margin: 0; font-size: 1.25rem; font-weight: 600;">
                    <i class="fas fa-shopping-cart" style="color: #9CA3AF; margin-right: 0.5rem;"></i>
                    Список заказов
                </h3>
            </div>
            <div class="orders-card-body">
                <!-- Фильтры -->
                <form method="GET" action="{{ route('admin.orders.index') }}" style="margin-bottom: 1.5rem;">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="status" style="color: var(--text-primary); margin-bottom: 0.5rem; display: block;">Статус</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="">Все статусы</option>
                                    <option value="cart" {{ request('status') == 'cart' ? 'selected' : '' }}>Корзина</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Ожидает оплаты</option>
                                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Оплачен</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Отменен</option>
                                    <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Истек</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="date_from" style="color: var(--text-primary); margin-bottom: 0.5rem; display: block;">Дата от</label>
                                <input type="date" name="date_from" id="date_from" class="form-control" value="{{ request('date_from') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="date_to" style="color: var(--text-primary); margin-bottom: 0.5rem; display: block;">Дата до</label>
                                <input type="date" name="date_to" id="date_to" class="form-control" value="{{ request('date_to') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label style="margin-bottom: 0.5rem; display: block; visibility: hidden;">Применить</label>
                                <button type="submit" class="btn-primary" style="width: 100%;">
                                    <i class="fas fa-filter" style="margin-right: 0.5rem;"></i> Применить
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

                @if($orders->count() > 0)
                    <div style="overflow-x: auto;">
                        <table class="orders-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Пользователь</th>
                                    <th>Кол-во билетов</th>
                                    <th>Сумма</th>
                                    <th>Статус</th>
                                    <th>Дата создания</th>
                                    <th style="width: 150px;">Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>
                                        @if($order->user)
                                            <i class="fas fa-user" style="color: #9CA3AF; margin-right: 0.25rem;"></i>
                                            {{ $order->user->name }}
                                        @else
                                            <span class="text-muted">Гость</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge-info">{{ $order->tickets->count() }}</span>
                                    </td>
                                    <td>
                                        <strong>{{ number_format($order->total_amount, 2) }} {{ $order->currency }}</strong>
                                    </td>
                                    <td>
                                        @php
                                            $statusClass = 'status-' . $order->status;
                                            $statusText = [
                                                'cart' => 'Корзина',
                                                'pending' => 'Ожидает оплаты',
                                                'paid' => 'Оплачен',
                                                'cancelled' => 'Отменен',
                                                'expired' => 'Истек'
                                            ][$order->status] ?? $order->status;
                                        @endphp
                                        <span class="status-badge {{ $statusClass }}">{{ $statusText }}</span>
                                    </td>
                                    <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                                    <td>
                                        <div style="display: flex; gap: 0.25rem;">
                                            <a href="{{ route('admin.orders.show', $order) }}" 
                                               class="btn-info" 
                                               title="Просмотр">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.orders.edit', $order) }}" 
                                               class="btn-warning" 
                                               title="Изменить статус">
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
                                Показано {{ $orders->firstItem() }} - {{ $orders->lastItem() }} 
                                из {{ $orders->total() }} записей
                            </small>
                        </div>
                        <div>
                            {{ $orders->links() }}
                        </div>
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-shopping-cart fa-3x"></i>
                        <h4>Заказы не найдены</h4>
                        <p>Нет заказов, соответствующих выбранным критериям.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
