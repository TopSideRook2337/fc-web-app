@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Панель управления')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@push('styles')
<style>
    /* Современный дизайн Dashboard с поддержкой темизации */
    .dashboard-container {
        font-family: 'Inter', 'Roboto', 'Helvetica Neue', sans-serif;
    }
    
    /* Карточки-счётчики с поддержкой темизации */
    .stats-card {
        background: var(--bg-card);
        border-radius: 12px;
        padding: 24px;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-color);
        transition: all 0.2s ease;
        margin-bottom: 24px;
    }
    
    .stats-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-xl);
    }
    
    .stats-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: white;
        margin-bottom: 16px;
    }
    
    .stats-number {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 8px;
        color: var(--text-primary);
    }
    
    .stats-label {
        font-size: 14px;
        color: var(--text-secondary);
        font-weight: 500;
    }
    
    /* Цвета для карточек */
    .stats-users { background: #2563EB; }
    .stats-posts { background: #059669; }
    .stats-games { background: #7C3AED; }
    .stats-orders { background: #F59E0B; }
    
    /* Блок статистики заказов */
    .orders-stats {
        background: var(--bg-card);
        border-radius: 12px;
        padding: 24px;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-color);
        margin-bottom: 24px;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .orders-stats h3 {
        font-size: 18px;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 20px;
    }
    
    .orders-stats .row {
        flex: 1;
    }
    
    .stat-block {
        text-align: center;
        padding: 20px;
        border-radius: 8px;
        background: var(--border-light);
    }
    
    .stat-block.pending {
        background: rgba(245, 158, 11, 0.1);
        border: 1px solid var(--accent-warning);
    }
    
    .stat-block.paid {
        background: rgba(16, 185, 129, 0.1);
        border: 1px solid var(--accent-success);
    }
    
    .stat-icon {
        font-size: 32px;
        margin-bottom: 12px;
    }
    
    .stat-number {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 8px;
    }
    
    .stat-label {
        font-size: 14px;
        font-weight: 500;
    }
    
    .pending .stat-icon { color: var(--accent-warning); }
    .pending .stat-number { color: var(--accent-warning); }
    .pending .stat-label { color: var(--accent-warning); }
    
    .paid .stat-icon { color: var(--accent-success); }
    .paid .stat-number { color: var(--accent-success); }
    .paid .stat-label { color: var(--accent-success); }
    
    /* Блок ближайших матчей */
    .games-card {
        background: var(--bg-card);
        border-radius: 12px;
        padding: 24px;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-color);
        margin-bottom: 24px;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .games-card h3 {
        font-size: 18px;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 20px;
    }
    
    .games-content {
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    
    .games-list {
        flex: 1;
    }
    
    .games-empty {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .game-item {
        padding: 16px;
        border-radius: 8px;
        background: var(--border-light);
        margin-bottom: 12px;
        border-left: 4px solid var(--accent-purple);
    }
    
    .game-title {
        font-size: 16px;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 4px;
    }
    
    .game-stadium {
        font-size: 14px;
        color: var(--text-secondary);
        margin-bottom: 8px;
    }
    
    .game-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .game-date {
        font-size: 14px;
        font-weight: 600;
        color: var(--text-primary);
    }
    
    .game-status {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }
    
    .status-open {
        background: rgba(16, 185, 129, 0.1);
        color: var(--accent-success);
    }
    
    .status-closed {
        background: rgba(239, 68, 68, 0.1);
        color: var(--accent-danger);
    }
    
    /* Таблица последних заказов */
    .orders-table-card {
        background: var(--bg-card);
        border-radius: 12px;
        padding: 24px;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-color);
        margin-top: 24px;
    }
    
    .orders-table-card h3 {
        font-size: 18px;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 20px;
    }
    
    .table-modern {
        background: var(--bg-card);
        border-radius: 8px;
        overflow: hidden;
    }
    
    .table-modern thead {
        background: var(--border-light);
    }
    
    .table-modern thead th {
        font-weight: 600;
        color: var(--text-primary);
        border: none;
        padding: 16px;
        font-size: 14px;
    }
    
    .table-modern tbody tr:nth-child(even) {
        background: var(--border-light);
    }
    
    .table-modern tbody td {
        border: none;
        padding: 16px;
        vertical-align: middle;
    }
    
    .status-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }
    
    .status-cart {
        background: rgba(107, 114, 128, 0.1);
        color: #6B7280;
    }
    
    .status-pending {
        background: rgba(245, 158, 11, 0.1);
        color: var(--accent-warning);
    }
    
    .status-paid {
        background: rgba(16, 185, 129, 0.1);
        color: var(--accent-success);
    }
    
    .status-cancelled {
        background: rgba(239, 68, 68, 0.1);
        color: var(--accent-danger);
    }
    
    .status-expired {
        background: rgba(107, 114, 128, 0.1);
        color: #6B7280;
    }
    
    .user-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: var(--border-color);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-right: 8px;
        font-size: 14px;
        color: var(--text-secondary);
    }
    
    /* Адаптивность */
    @media (max-width: 768px) {
        .stats-card {
            margin-bottom: 16px;
        }
        
        .stat-block {
            margin-bottom: 16px;
        }
        
        .game-meta {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }
    }
</style>
@endpush

@section('content')
    <!-- Карточки-счётчики -->
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="stats-card">
                <div class="stats-icon stats-users">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stats-number">{{ $stats['total_users'] }}</div>
                <div class="stats-label">Пользователи</div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="stats-card">
                <div class="stats-icon stats-posts">
                    <i class="fas fa-newspaper"></i>
                </div>
                <div class="stats-number">{{ $stats['total_posts'] }}</div>
                <div class="stats-label">Новости</div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="stats-card">
                <div class="stats-icon stats-games">
                    <i class="fas fa-futbol"></i>
                </div>
                <div class="stats-number">{{ $stats['total_games'] }}</div>
                <div class="stats-label">Матчи</div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="stats-card">
                <div class="stats-icon stats-orders">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="stats-number">{{ $stats['total_orders'] }}</div>
                <div class="stats-label">Заказы</div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Статистика заказов -->
        <div class="col-md-6">
            <div class="orders-stats">
                <h3>Статистика заказов</h3>
                <div class="row">
                    <div class="col-6">
                        <div class="stat-block pending">
                            <div class="stat-icon"><i class="fas fa-hourglass-half"></i></div>
                            <div class="stat-number">{{ $stats['pending_orders'] }}</div>
                            <div class="stat-label">Ожидают оплаты</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="stat-block paid">
                            <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
                            <div class="stat-number">{{ $stats['paid_orders'] }}</div>
                            <div class="stat-label">Оплачены</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ближайшие матчи -->
        <div class="col-md-6">
            <div class="games-card">
                <h3>Ближайшие матчи</h3>
                <div class="games-content">
                    @if($upcoming_games->count() > 0)
                        <div class="games-list">
                            @foreach($upcoming_games as $game)
                                <div class="game-item">
                                    <div class="game-title">{{ $game->title }}</div>
                                    <div class="game-stadium">{{ $game->stadium->name ?? 'Стадион не указан' }}</div>
                                    <div class="game-meta">
                                        <div class="game-date">{{ $game->start_at->format('d.m.Y H:i') }}</div>
                                        <span class="game-status {{ $game->status === 'tickets_open' ? 'status-open' : 'status-closed' }}">
                                            @if($game->status === 'tickets_open')
                                                <i class="fas fa-check-circle"></i> Продажа открыта
                                            @else
                                                <i class="fas fa-ban"></i> Продажа закрыта
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="games-empty">
                            <div class="text-center text-muted">
                                <i class="fas fa-calendar-alt fa-2x mb-2"></i>
                                <p>Нет предстоящих матчей</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Последние заказы -->
    <div class="row">
        <div class="col-12">
            <div class="orders-table-card">
                <h3>Последние заказы</h3>
                @if($recent_orders->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-modern">
                            <thead>
                                <tr>
                                    <th style="text-align: left;">ID</th>
                                    <th style="text-align: left;">Пользователь</th>
                                    <th style="text-align: center;">Сумма</th>
                                    <th style="text-align: center;">Статус</th>
                                    <th style="text-align: center;">Дата</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recent_orders as $index => $order)
                                    <tr>
                                        <td style="text-align: left; font-weight: 600;">#{{ $order->id }}</td>
                                        <td style="text-align: left;">
                                            <div class="d-flex align-items-center">
                                                <div class="user-avatar">
                                                    <i class="fas fa-user-circle"></i>
                                                </div>
                                                {{ $order->user->name ?? 'Гость' }}
                                            </div>
                                        </td>
                                        <td style="text-align: center; font-weight: 600;">{{ number_format($order->total_amount, 0, ',', ' ') }} ₽</td>
                                        <td style="text-align: center;">
                                            @php
                                                $statusConfig = [
                                                    'cart' => ['class' => 'status-cart', 'icon' => 'fas fa-shopping-cart', 'text' => 'Корзина'],
                                                    'pending' => ['class' => 'status-pending', 'icon' => 'fas fa-hourglass-half', 'text' => 'Ожидает оплаты'],
                                                    'paid' => ['class' => 'status-paid', 'icon' => 'fas fa-check-circle', 'text' => 'Оплачен'],
                                                    'cancelled' => ['class' => 'status-cancelled', 'icon' => 'fas fa-times-circle', 'text' => 'Отменен'],
                                                    'expired' => ['class' => 'status-expired', 'icon' => 'fas fa-clock', 'text' => 'Истек']
                                                ];
                                                $status = $statusConfig[$order->status] ?? ['class' => 'status-pending', 'icon' => 'fas fa-question-circle', 'text' => $order->status];
                                            @endphp
                                            <span class="status-badge {{ $status['class'] }}">
                                                <i class="{{ $status['icon'] }}"></i> {{ $status['text'] }}
                                            </span>
                                        </td>
                                        <td style="text-align: center;">{{ $order->created_at->format('d.m.Y H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-receipt fa-2x mb-2"></i>
                        <p>Нет заказов</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection