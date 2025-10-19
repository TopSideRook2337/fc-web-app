@extends('admin.layouts.app')

@section('title', $game->title)
@section('page-title', 'Просмотр матча')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.games.index') }}">Матчи</a></li>
    <li class="breadcrumb-item active">{{ $game->title }}</li>
@endsection

@push('styles')
<style>
.team-logo-large {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 50%;
    border: 3px solid #dee2e6;
}
.logo-placeholder-large {
    width: 80px;
    height: 80px;
    border: 3px dashed #dee2e6;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #f8f9fa;
}
.match-info {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 10px;
    padding: 2rem;
    margin-bottom: 2rem;
}
.team-vs {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 2rem;
    margin: 1rem 0;
}
.vs-text {
    font-size: 1.5rem;
    font-weight: bold;
    background: rgba(255,255,255,0.2);
    padding: 0.5rem 1rem;
    border-radius: 50px;
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
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Информация о матче</h3>
                </div>
                <div class="card-body">
                    <!-- Основная информация о матче -->
                    <div class="match-info">
                        <h2 class="text-center mb-4">{{ $game->title }}</h2>
                        
                        <div class="team-vs">
                            <div class="text-center">
                                @if($game->home_team_logo_path)
                                    <img src="{{ asset('storage/' . $game->home_team_logo_path) }}" alt="{{ $game->home_team_name }}" class="team-logo-large mb-2">
                                @else
                                    <div class="logo-placeholder-large mb-2">
                                        <i class="fa fa-user fa-2x text-muted"></i>
                                    </div>
                                @endif
                                <h4>{{ $game->home_team_name }}</h4>
                            </div>
                            
                            <div class="vs-text">VS</div>
                            
                            <div class="text-center">
                                @if($game->away_team_logo_path)
                                    <img src="{{ asset('storage/' . $game->away_team_logo_path) }}" alt="{{ $game->away_team_name }}" class="team-logo-large mb-2">
                                @else
                                    <div class="logo-placeholder-large mb-2">
                                        <i class="fa fa-user fa-2x text-muted"></i>
                                    </div>
                                @endif
                                <h4>{{ $game->away_team_name }}</h4>
                            </div>
                        </div>
                    </div>

                    <!-- Детальная информация -->
                    <div class="row">
                        <div class="col-md-6">
                            <h5><i class="fa fa-calendar text-primary"></i> Дата и время</h5>
                            <p class="text-muted">
                                <strong>{{ $game->start_at ? $game->start_at->format('d.m.Y H:i') : 'Не указано' }}</strong>
                                @if($game->start_at)
                                    @if($game->start_at->isFuture())
                                        <br><span class="badge badge-success">Предстоящий матч</span>
                                    @elseif($game->start_at->isPast())
                                        <br><span class="badge badge-secondary">Прошедший матч</span>
                                    @endif
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h5><i class="fa fa-building text-primary"></i> Стадион</h5>
                            <p class="text-muted">
                                <strong>{{ $game->stadium->name ?? 'Не указан' }}</strong>
                                @if($game->stadium)
                                    <br><small>{{ $game->stadium->address }}</small>
                                    <br><small>Вместимость: {{ $game->stadium->total_capacity }} мест</small>
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <h5><i class="fa fa-flag text-primary"></i> Статус матча</h5>
                            <p class="text-muted">
                                @php
                                    $statusLabels = [
                                        'draft' => ['label' => 'Черновик', 'class' => 'secondary'],
                                        'ready' => ['label' => 'Готов', 'class' => 'info'],
                                        'tickets_open' => ['label' => 'Продажи открыты', 'class' => 'success'],
                                        'completed' => ['label' => 'Завершен', 'class' => 'primary'],
                                        'cancelled' => ['label' => 'Отменен', 'class' => 'danger']
                                    ];
                                    $status = $statusLabels[$game->status] ?? ['label' => $game->status, 'class' => 'secondary'];
                                @endphp
                                <span class="badge badge-{{ $status['class'] }} badge-lg">
                                    {{ $status['label'] }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h5><i class="fa fa-info-circle text-primary"></i> Дополнительно</h5>
                            <p class="text-muted">
                                <small>
                                    Создан: {{ $game->created_at ? $game->created_at->format('d.m.Y H:i') : 'Не указано' }}<br>
                                    Обновлен: {{ $game->updated_at ? $game->updated_at->format('d.m.Y H:i') : 'Не указано' }}
                                </small>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Действия</h3>
                </div>
                <div class="card-body">
                    <!-- Кнопка "Назад" - сверху, белая с синей рамкой -->
                    <div class="mb-3">
                        <a href="{{ route('admin.games.index') }}" class="btn btn-outline-primary btn-block">
                            <i class="fa fa-arrow-left"></i> Назад к списку
                        </a>
                    </div>
                    
                    <!-- Кнопки "Редактировать" и "Удалить" - в одну строку -->
                    <div class="row">
                        <div class="col-6">
                            <a href="{{ route('admin.games.edit', $game) }}" class="btn btn-success btn-block">
                                <i class="fa fa-edit"></i> Редактировать
                            </a>
                        </div>
                        <div class="col-6">
                            <form action="{{ route('admin.games.destroy', $game) }}" method="POST" onsubmit="return confirmDelete('{{ $game->title }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-block">
                                    <i class="fa fa-trash"></i> Удалить
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            @if($game->stadium)
            <div class="card mt-3">
                <div class="card-header">
                    <h3 class="card-title">Информация о стадионе</h3>
                </div>
                <div class="card-body">
                    <h6>{{ $game->stadium->name }}</h6>
                    <p class="text-muted">
                        <i class="fa fa-map-marker-alt"></i> {{ $game->stadium->address }}<br>
                        <i class="fa fa-users"></i> {{ $game->stadium->total_capacity }} мест<br>
                        <i class="fa fa-flag"></i> {{ $game->stadium->is_active ? 'Активен' : 'Неактивен' }}
                    </p>
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function confirmDelete(gameTitle) {
        return confirm(`Вы уверены, что хотите удалить матч "${gameTitle}"?\n\nЭто действие нельзя отменить!`);
    }
</script>
@endpush
