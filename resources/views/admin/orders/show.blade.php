@extends('admin.layouts.app')

@section('title', 'Просмотр заказа #' . $order->id)
@section('page-title', 'Заказ #' . $order->id)

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Заказы</a></li>
    <li class="breadcrumb-item active">Заказ #{{ $order->id }}</li>
@endsection

@push('styles')
<style>
.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 0.25rem;
    font-weight: 500;
    font-size: 1rem;
}
.status-cart { background-color: #4B5563; color: #FFFFFF; }
.status-pending { background-color: #D97706; color: #FFFFFF; }
.status-paid { background-color: #059669; color: #FFFFFF; }
.status-cancelled { background-color: #DC2626; color: #FFFFFF; }
.status-expired { background-color: #6B7280; color: #FFFFFF; }

.info-box {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
    padding: 1.5rem;
    margin-bottom: 1.5rem;
}

.info-box h5 {
    margin-bottom: 1rem;
    font-weight: 600;
    color: var(--text-primary);
}

.info-box i {
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
    width: 40%;
}

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

.orders-card-footer {
    background: var(--card-bg);
    border-top: 1px solid var(--border-color);
    padding: 16px;
}

.tickets-table {
    width: 100%;
    color: var(--text-primary);
    background: transparent;
    border-collapse: collapse;
}

.tickets-table thead th {
    background: var(--card-bg);
    color: var(--text-primary);
    font-weight: 600;
    border-bottom: 1px solid var(--border-color);
    padding: 12px;
    text-align: left;
}

.tickets-table tbody tr {
    border-bottom: 1px solid #374151;
}

.tickets-table tbody td {
    padding: 12px;
    color: var(--text-primary);
    background: var(--card-bg);
}

.badge-secondary {
    background-color: #4B5563;
    color: #FFFFFF;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    font-size: 0.875rem;
}

.badge-warning {
    background-color: #D97706;
    color: #FFFFFF;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    font-size: 0.875rem;
}

.badge-success {
    background-color: #059669;
    color: #FFFFFF;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    font-size: 0.875rem;
}

.badge-info {
    background-color: #3B82F6;
    color: #FFFFFF;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    font-size: 0.875rem;
}

.badge-danger {
    background-color: #DC2626;
    color: #FFFFFF;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    font-size: 0.875rem;
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

.empty-state p {
    color: #6B7280;
    margin-bottom: 0;
}

/* Стили для кнопок действий */
.btn-block {
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 500;
    transition: all 0.2s ease;
}

.btn-outline-primary {
    border: 2px solid #007bff;
    color: #007bff;
    background: white;
}

.btn-outline-primary:hover {
    background: #007bff;
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,123,255,0.3);
}

.btn-success {
    background: #28a745;
    border-color: #28a745;
}

.btn-success:hover {
    background: #218838;
    border-color: #1e7e34;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(40,167,69,0.3);
}

.btn-danger {
    background: #dc3545;
    border-color: #dc3545;
}

.btn-danger:hover {
    background: #c82333;
    border-color: #bd2130;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(220,53,69,0.3);
}

.btn i {
    margin-right: 0.5rem;
}
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="info-box">
            <h5>
                <i class="fas fa-info-circle"></i>
                Информация о заказе
            </h5>
            <table class="info-table">
                <tr>
                    <td>ID:</td>
                    <td>{{ $order->id }}</td>
                </tr>
                <tr>
                    <td>Статус:</td>
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
                </tr>
                <tr>
                    <td>Сумма:</td>
                    <td><strong>{{ number_format($order->total_amount, 2) }} {{ $order->currency }}</strong></td>
                </tr>
                <tr>
                    <td>Билетов:</td>
                    <td><span class="badge-info">{{ $order->tickets->count() }}</span></td>
                </tr>
                <tr>
                    <td>Создан:</td>
                    <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                </tr>
                @if($order->paid_at)
                <tr>
                    <td>Оплачен:</td>
                    <td>{{ $order->paid_at->format('d.m.Y H:i') }}</td>
                </tr>
                @endif
                @if($order->payment_method)
                <tr>
                    <td>Способ оплаты:</td>
                    <td>{{ $order->payment_method }}</td>
                </tr>
                @endif
            </table>
        </div>

        <div class="info-box">
            <h5>
                <i class="fas fa-user"></i>
                Покупатель
            </h5>
            @if($order->user)
                <table class="info-table">
                    <tr>
                        <td>Имя:</td>
                        <td>{{ $order->user->name }}</td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td>{{ $order->user->email }}</td>
                    </tr>
                </table>
            @else
                <p class="text-muted" style="margin-bottom: 0;">Гостевой заказ</p>
            @endif
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-cog"></i> Действия</h3>
            </div>
            <div class="card-body">
                <!-- Кнопка "Назад" - сверху, белая с синей рамкой -->
                <div class="mb-3">
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-primary btn-block">
                        <i class="fa fa-arrow-left"></i> Назад к списку
                    </a>
                </div>
                
                <!-- Кнопка "Редактировать" -->
                <div class="mb-0">
                    <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-success btn-block">
                        <i class="fa fa-edit"></i> Изменить статус
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="orders-card">
            <div class="orders-card-header">
                <h3 style="margin: 0; font-size: 1.25rem; font-weight: 600;">
                    <i class="fas fa-ticket-alt" style="color: #9CA3AF; margin-right: 0.5rem;"></i>
                    Билеты в заказе
                </h3>
            </div>
            <div class="orders-card-body">
                @if($order->tickets->count() > 0)
                    <div style="overflow-x: auto;">
                        <table class="tickets-table">
                            <thead>
                                <tr>
                                    <th>Матч</th>
                                    <th>Сектор</th>
                                    <th>Ряд</th>
                                    <th>Место</th>
                                    <th>Статус</th>
                                    <th>Дата матча</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->tickets as $ticket)
                                <tr>
                                    <td>
                                        <strong>{{ $ticket->game->title ?? 'N/A' }}</strong>
                                    </td>
                                    <td>
                                        @if($ticket->seat && $ticket->seat->sector)
                                            <span class="badge-secondary">
                                                {{ $ticket->seat->sector->name }}
                                            </span>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>{{ $ticket->seat->row_number ?? 'N/A' }}</td>
                                    <td>{{ $ticket->seat->seat_number ?? 'N/A' }}</td>
                                    <td>
                                        @php
                                            $ticketStatusClass = [
                                                'reserved' => 'warning',
                                                'paid' => 'success',
                                                'used' => 'info',
                                                'cancelled' => 'danger'
                                            ][$ticket->status] ?? 'secondary';
                                            $ticketStatusText = [
                                                'reserved' => 'Забронирован',
                                                'paid' => 'Оплачен',
                                                'used' => 'Использован',
                                                'cancelled' => 'Отменен'
                                            ][$ticket->status] ?? $ticket->status;
                                        @endphp
                                        <span class="badge-{{ $ticketStatusClass }}">
                                            {{ $ticketStatusText }}
                                        </span>
                                    </td>
                                    <td>{{ $ticket->game->date ? $ticket->game->date->format('d.m.Y H:i') : 'N/A' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-ticket-alt fa-2x"></i>
                        <p>Билеты отсутствуют</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
