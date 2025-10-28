@extends('admin.layouts.app')

@section('title', 'Редактирование заказа #' . $order->id)
@section('page-title', 'Редактирование заказа #' . $order->id)

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Заказы</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.orders.show', $order) }}">Заказ #{{ $order->id }}</a></li>
    <li class="breadcrumb-item active">Редактирование</li>
@endsection

@push('styles')
<style>
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

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    color: var(--text-primary);
    margin-bottom: 0.5rem;
    display: block;
    font-weight: 500;
}

.form-group label i {
    color: #9CA3AF;
    margin-right: 0.5rem;
}

.form-control-static {
    color: var(--text-primary);
    padding: 0.375rem 0;
}

.form-control {
    background: var(--input-bg);
    border: 1px solid var(--border-color);
    color: var(--text-primary);
    border-radius: 4px;
    padding: 0.5rem 0.75rem;
    width: 100%;
}

.form-control:focus {
    background: var(--input-bg);
    border-color: #3B82F6;
    color: var(--text-primary);
    outline: none;
}

.form-control.is-invalid {
    border-color: #DC2626;
}

.invalid-feedback {
    color: #DC2626;
    font-size: 0.875rem;
    margin-top: 0.25rem;
    display: block;
}

.alert-info {
    background-color: rgba(59, 130, 246, 0.1);
    border: 1px solid #3B82F6;
    color: var(--text-primary);
    padding: 1rem;
    border-radius: 4px;
    margin-top: 1rem;
}

.alert-info i {
    color: #3B82F6;
    margin-right: 0.5rem;
}

.alert-info ul {
    margin-bottom: 0;
    margin-top: 0.5rem;
    padding-left: 1.5rem;
}

.btn-secondary {
    background-color: #6B7280;
    border-color: #6B7280;
    color: #FFFFFF;
    padding: 0.5rem 1rem;
    border-radius: 4px;
    text-decoration: none;
    display: inline-block;
    border: none;
    cursor: pointer;
}

.btn-secondary:hover {
    background-color: #4B5563;
    border-color: #4B5563;
    color: #FFFFFF;
    text-decoration: none;
}

.btn-primary {
    background-color: #3B82F6;
    border-color: #3B82F6;
    color: #FFFFFF;
    padding: 0.5rem 1rem;
    border-radius: 4px;
    text-decoration: none;
    display: inline-block;
    border: none;
    cursor: pointer;
}

.btn-primary:hover {
    background-color: #2563EB;
    border-color: #2563EB;
    color: #FFFFFF;
    text-decoration: none;
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
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="orders-card">
            <div class="orders-card-header">
                <h3 style="margin: 0; font-size: 1.25rem; font-weight: 600;">
                    <i class="fas fa-edit" style="color: #9CA3AF; margin-right: 0.5rem;"></i>
                    Изменение статуса заказа
                </h3>
            </div>
            <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="orders-card-body">
                    <div class="form-group">
                        <label>
                            <i class="fas fa-tag"></i>
                            Текущий статус
                        </label>
                        <p class="form-control-static">
                            @php
                                $currentStatusText = [
                                    'cart' => 'Корзина',
                                    'pending' => 'Ожидает оплаты',
                                    'paid' => 'Оплачен',
                                    'cancelled' => 'Отменен',
                                    'expired' => 'Истек'
                                ][$order->status] ?? $order->status;
                            @endphp
                            <strong>{{ $currentStatusText }}</strong>
                        </p>
                    </div>

                    <div class="form-group">
                        <label for="status">
                            <i class="fas fa-exchange-alt"></i>
                            Новый статус
                        </label>
                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                            @foreach($statuses as $value => $label)
                                <option value="{{ $value }}" {{ old('status', $order->status) == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Важно:</strong>
                        <ul>
                            <li>При смене статуса на "Оплачен" все билеты также получат статус "Оплачен".</li>
                            <li>При смене статуса на "Отменен" или "Истек" все билеты будут отменены.</li>
                            <li>Нельзя изменить статус оплаченного заказа обратно на "Корзина" или "Ожидает оплаты".</li>
                        </ul>
                    </div>
                </div>
                <div class="orders-card-footer">
                    <div style="display: flex; justify-content: space-between;">
                        <a href="{{ route('admin.orders.show', $order) }}" class="btn-secondary">
                            <i class="fas fa-times" style="margin-right: 0.5rem;"></i>
                            Отмена
                        </a>
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-save" style="margin-right: 0.5rem;"></i>
                            Сохранить изменения
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-6">
        <div class="orders-card">
            <div class="orders-card-header">
                <h3 style="margin: 0; font-size: 1.25rem; font-weight: 600;">
                    <i class="fas fa-info-circle" style="color: #9CA3AF; margin-right: 0.5rem;"></i>
                    Информация о заказе
                </h3>
            </div>
            <div class="orders-card-body">
                <table class="info-table">
                    <tr>
                        <td>ID заказа:</td>
                        <td>{{ $order->id }}</td>
                    </tr>
                    <tr>
                        <td>Покупатель:</td>
                        <td>{{ $order->user ? $order->user->name : 'Гость' }}</td>
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
                        <td>Дата создания:</td>
                        <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                    </tr>
                    @if($order->paid_at)
                    <tr>
                        <td>Дата оплаты:</td>
                        <td>{{ $order->paid_at->format('d.m.Y H:i') }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
