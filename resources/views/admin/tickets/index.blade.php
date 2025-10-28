@extends('admin.layouts.app')

@section('title', 'Билеты')
@section('page-title', 'Управление билетами')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Билеты</li>
@endsection

@push('styles')
<style>
.team-logo {
    width: 30px;
    height: 30px;
    object-fit: cover;
    border-radius: 50%;
}
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
.badge-draft { background-color: #6B7280; color: #FFFFFF; }
.badge-ready { background-color: #3B82F6; color: #FFFFFF; }
.badge-tickets_open { background-color: #10B981; color: #FFFFFF; }
.badge-completed { background-color: #6366F1; color: #FFFFFF; }
.badge-cancelled { background-color: #EF4444; color: #FFFFFF; }
</style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Выберите матч</h3>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">Выберите матч, чтобы посмотреть проданные билеты</p>
                    
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Матч</th>
                                <th>Дата и время</th>
                                <th>Стадион</th>
                                <th>Статус</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($games as $game)
                                <tr>
                                    <td>{{ $game->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($game->home_team_logo_path)
                                                <img src="{{ asset('storage/' . $game->home_team_logo_path) }}" alt="Home" class="team-logo mr-2">
                                            @endif
                                            <span>{{ $game->home_team_name }}</span>
                                            <span class="mx-2">vs</span>
                                            @if($game->away_team_logo_path)
                                                <img src="{{ asset('storage/' . $game->away_team_logo_path) }}" alt="Away" class="team-logo mr-2">
                                            @endif
                                            <span>{{ $game->away_team_name }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $game->start_at->format('d.m.Y H:i') }}</td>
                                    <td>{{ $game->stadium->name }}</td>
                                    <td>
                                        @php
                                            $statusConfig = [
                                                'draft' => ['text' => 'Черновик', 'class' => 'badge-draft'],
                                                'ready' => ['text' => 'Готов', 'class' => 'badge-ready'],
                                                'tickets_open' => ['text' => 'Продажа открыта', 'class' => 'badge-tickets_open'],
                                                'completed' => ['text' => 'Завершён', 'class' => 'badge-completed'],
                                                'cancelled' => ['text' => 'Отменён', 'class' => 'badge-cancelled'],
                                            ];
                                            $status = $statusConfig[$game->status] ?? ['text' => $game->status, 'class' => 'badge-secondary'];
                                        @endphp
                                        <span class="badge {{ $status['class'] }}">{{ $status['text'] }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.tickets.game-tickets', $game) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-ticket-alt"></i> Билеты
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Матчи не найдены</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($games->hasPages())
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            Показано {{ $games->firstItem() }} - {{ $games->lastItem() }} из {{ $games->total() }}
                        </div>
                        <div>
                            {{ $games->links() }}
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection

