@extends('admin.layouts.app')

@section('title', 'Просмотр бонусной записи')
@section('page-title', 'Просмотр бонусной записи')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.loyalty-points.index') }}">Бонусные баллы</a></li>
    <li class="breadcrumb-item active">Запись #{{ $loyaltyPoint->id }}</li>
@endsection

@push('styles')
<style>
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

.btn i {
    margin-right: 0.5rem;
}

.info-card {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 0.25rem;
    margin-bottom: 1rem;
    border-left: 4px solid #007bff;
}

.info-card h5 {
    font-size: 0.9rem;
    color: #6c757d;
    margin-bottom: 0.5rem;
    text-transform: uppercase;
}

.info-card p {
    font-size: 1.2rem;
    font-weight: 500;
    margin: 0;
}

.points-display {
    font-size: 3rem;
    font-weight: bold;
    color: #28a745;
    text-align: center;
    padding: 2rem;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 0.5rem;
    margin: 1rem 0;
}
</style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Информация о начислении</h3>
                </div>
                <div class="card-body">
                    <div class="points-display">
                        <i class="fa fa-coins text-warning"></i> +{{ $loyaltyPoint->points }} баллов
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="info-card">
                                <h5><i class="fa fa-user"></i> Пользователь</h5>
                                @if($loyaltyPoint->user)
                                    <p>
                                        <a href="{{ route('admin.users.show', $loyaltyPoint->user) }}">
                                            {{ $loyaltyPoint->user->name }}
                                        </a>
                                    </p>
                                    <small class="text-muted">{{ $loyaltyPoint->user->email }}</small>
                                @else
                                    <p class="text-muted">Не указан</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-card">
                                <h5><i class="fa fa-calendar"></i> Дата начисления</h5>
                                <p>{{ $loyaltyPoint->created_at ? $loyaltyPoint->created_at->format('d.m.Y H:i') : 'Не указано' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="info-card">
                                <h5><i class="fa fa-info-circle"></i> Причина начисления</h5>
                                <p>{{ $loyaltyPoint->reason ?? 'Не указана' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-card">
                                <h5><i class="fa fa-shopping-cart"></i> Связанный заказ</h5>
                                @if($loyaltyPoint->order)
                                    <p>
                                        <a href="{{ route('admin.orders.show', $loyaltyPoint->order) }}" class="btn btn-info btn-sm">
                                            <i class="fa fa-eye"></i> Заказ #{{ $loyaltyPoint->order->id }}
                                        </a>
                                    </p>
                                    <small class="text-muted">
                                        Сумма: {{ number_format($loyaltyPoint->order->total_amount, 2) }} {{ $loyaltyPoint->order->currency }}
                                    </small>
                                @else
                                    <p class="text-muted">Не привязан</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if($loyaltyPoint->expires_at)
                    <div class="alert alert-warning">
                        <i class="fa fa-clock"></i> 
                        <strong>Срок действия:</strong> 
                        {{ $loyaltyPoint->expires_at->format('d.m.Y H:i') }}
                        @if($loyaltyPoint->expires_at->isPast())
                            <span class="badge badge-danger ml-2">Истёк</span>
                        @else
                            <span class="badge badge-success ml-2">Активен</span>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-cog"></i> Действия</h3>
                </div>
                <div class="card-body">
                    <!-- Кнопка "Назад" -->
                    <div class="mb-3">
                        <a href="{{ route('admin.loyalty-points.index') }}" class="btn btn-outline-primary btn-block">
                            <i class="fa fa-arrow-left"></i> Назад к списку
                        </a>
                    </div>
                </div>
            </div>

            <!-- Дополнительная информация -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-info-circle"></i> Детали</h3>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <strong>ID записи:</strong> {{ $loyaltyPoint->id }}
                        </li>
                        <li class="mb-2">
                            <strong>ID пользователя:</strong> 
                            @if($loyaltyPoint->user)
                                <a href="{{ route('admin.users.show', $loyaltyPoint->user) }}">
                                    {{ $loyaltyPoint->user_id }}
                                </a>
                            @else
                                {{ $loyaltyPoint->user_id }}
                            @endif
                        </li>
                        @if($loyaltyPoint->order)
                        <li class="mb-2">
                            <strong>ID заказа:</strong> 
                            <a href="{{ route('admin.orders.show', $loyaltyPoint->order) }}">
                                {{ $loyaltyPoint->related_order_id }}
                            </a>
                        </li>
                        @endif
                        <li class="mb-2">
                            <strong>Создано:</strong> {{ $loyaltyPoint->created_at->format('d.m.Y H:i:s') }}
                        </li>
                        <li class="mb-2">
                            <strong>Обновлено:</strong> {{ $loyaltyPoint->updated_at->format('d.m.Y H:i:s') }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection







