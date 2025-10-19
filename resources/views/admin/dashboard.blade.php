@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Панель управления')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
    <!-- Info boxes -->
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Пользователи</span>
                    <span class="info-box-number">{{ $stats['total_users'] }}</span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-newspaper"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Новости</span>
                    <span class="info-box-number">{{ $stats['total_posts'] }}</span>
                </div>
            </div>
        </div>
        <div class="clearfix hidden-md-up"></div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-futbol"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Матчи</span>
                    <span class="info-box-number">{{ $stats['total_games'] }}</span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-shopping-cart"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Заказы</span>
                    <span class="info-box-number">{{ $stats['total_orders'] }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Заказы по статусам -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Статистика заказов</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="description-block border-right">
                                <span class="description-percentage text-warning"><i class="fas fa-clock"></i></span>
                                <h5 class="description-header">{{ $stats['pending_orders'] }}</h5>
                                <span class="description-text">ОЖИДАЮТ ОПЛАТЫ</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="description-block">
                                <span class="description-percentage text-success"><i class="fas fa-check"></i></span>
                                <h5 class="description-header">{{ $stats['paid_orders'] }}</h5>
                                <span class="description-text">ОПЛАЧЕНЫ</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ближайшие матчи -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Ближайшие матчи</h3>
                </div>
                <div class="card-body">
                    @if($upcoming_games->count() > 0)
                        @foreach($upcoming_games as $game)
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    <strong>{{ $game->title }}</strong><br>
                                    <small class="text-muted">{{ $game->stadium->name ?? 'Стадион не указан' }}</small>
                                </div>
                                <div class="text-right">
                                    <small>{{ $game->start_at->format('d.m.Y H:i') }}</small><br>
                                    <span class="badge badge-{{ $game->status === 'tickets_open' ? 'success' : 'warning' }}">
                                        {{ $game->status === 'tickets_open' ? 'Продажа открыта' : 'Продажа закрыта' }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted">Нет предстоящих матчей</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Последние заказы -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Последние заказы</h3>
                </div>
                <div class="card-body">
                    @if($recent_orders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Пользователь</th>
                                        <th>Сумма</th>
                                        <th>Статус</th>
                                        <th>Дата</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recent_orders as $order)
                                        <tr>
                                            <td>#{{ $order->id }}</td>
                                            <td>{{ $order->user->name ?? 'Гость' }}</td>
                                            <td>{{ number_format($order->total_amount, 0, ',', ' ') }} ₽</td>
                                            <td>
                                                <span class="badge badge-{{ 
                                                    $order->status === 'paid' ? 'success' : 
                                                    ($order->status === 'pending' ? 'warning' : 'secondary') 
                                                }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">Нет заказов</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

