@extends('admin.layouts.app')

@section('title', 'Билеты на матч')
@section('page-title', 'Билеты: ' . $game->home_team_name . ' vs ' . $game->away_team_name)

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.tickets.index') }}">Билеты</a></li>
    <li class="breadcrumb-item active">Билеты на матч #{{ $game->id }}</li>
@endsection

@push('styles')
<style>
.table {
    background-color: var(--card-bg);
    border-radius: 8px;
    overflow: hidden;
}
.table th {
    background-color: var(--card-bg);
    color: var(--text-primary);
    font-weight: 600;
    border-bottom: 1px solid var(--border-color);
    padding: 12px 16px;
}
.table td {
    background-color: var(--card-bg);
    color: var(--text-primary);
    border-bottom: 1px solid var(--border-color);
    padding: 12px 16px;
}
.table tbody tr:last-child td {
    border-bottom: none;
}
.badge {
    padding: 4px 8px;
    border-radius: 4px;
    font-weight: 500;
}
.badge-reserved { background-color: #F59E0B; color: #FFFFFF; }
.badge-paid { background-color: #10B981; color: #FFFFFF; }
.badge-used { background-color: #6366F1; color: #FFFFFF; }
.badge-cancelled { background-color: #EF4444; color: #FFFFFF; }
</style>
@endpush

@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5>{{ $game->title }}</h5>
                    <p class="mb-0">
                        <i class="fas fa-calendar"></i> {{ $game->start_at->format('d.m.Y H:i') }} |
                        <i class="fas fa-map-marker-alt"></i> {{ $game->stadium->name }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Список билетов</h3>
                </div>
                <div class="card-body">
                    <!-- Фильтры -->
                    <form method="GET" action="{{ route('admin.tickets.game-tickets', $game) }}" id="filters-form">
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <select class="form-control" name="status" id="status-filter">
                                    <option value="">Все статусы</option>
                                    <option value="reserved" {{ request('status') == 'reserved' ? 'selected' : '' }}>Забронирован</option>
                                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Оплачен</option>
                                    <option value="used" {{ request('status') == 'used' ? 'selected' : '' }}>Использован</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Отменён</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-control" name="sector_id" id="sector-filter">
                                    <option value="">Все сектора</option>
                                    @foreach($sectors as $sector)
                                        <option value="{{ $sector->id }}" {{ request('sector_id') == $sector->id ? 'selected' : '' }}>
                                            {{ $sector->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-filter"></i> Применить
                                </button>
                                <a href="{{ route('admin.tickets.game-tickets', $game) }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Сбросить
                                </a>
                            </div>
                        </div>
                    </form>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Сектор</th>
                                <th>Ряд</th>
                                <th>Место</th>
                                <th>Пользователь</th>
                                <th>Статус</th>
                                <th>Дата заказа</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tickets as $ticket)
                                <tr>
                                    <td>{{ $ticket->id }}</td>
                                    <td>{{ $ticket->seat->sector->name }}</td>
                                    <td>{{ $ticket->seat->row }}</td>
                                    <td>{{ $ticket->seat->number }}</td>
                                    <td>
                                        @if($ticket->order && $ticket->order->user)
                                            {{ $ticket->order->user->name }}
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $statusConfig = [
                                                'reserved' => ['text' => 'Забронирован', 'class' => 'badge-reserved'],
                                                'paid' => ['text' => 'Оплачен', 'class' => 'badge-paid'],
                                                'used' => ['text' => 'Использован', 'class' => 'badge-used'],
                                                'cancelled' => ['text' => 'Отменён', 'class' => 'badge-cancelled'],
                                            ];
                                            $status = $statusConfig[$ticket->status] ?? ['text' => $ticket->status, 'class' => 'badge-secondary'];
                                        @endphp
                                        <span class="badge {{ $status['class'] }}">{{ $status['text'] }}</span>
                                    </td>
                                    <td>{{ $ticket->created_at->format('d.m.Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('admin.tickets.show', $ticket) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> Просмотр
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">Билеты не найдены</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($tickets->hasPages())
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            Показано {{ $tickets->firstItem() }} - {{ $tickets->lastItem() }} из {{ $tickets->total() }}
                        </div>
                        <div>
                            {{ $tickets->links() }}
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusFilter = document.getElementById('status-filter');
    const sectorFilter = document.getElementById('sector-filter');
    const form = document.getElementById('filters-form');
    
    if (statusFilter) {
        statusFilter.addEventListener('change', () => form.submit());
    }
    
    if (sectorFilter) {
        sectorFilter.addEventListener('change', () => form.submit());
    }
});
</script>
@endpush

