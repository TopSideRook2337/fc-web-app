@extends('admin.layouts.app')

@section('title', 'Просмотр стадиона')
@section('page-title', 'Просмотр стадиона')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.stadiums.index') }}">Стадионы</a></li>
    <li class="breadcrumb-item active">Просмотр</li>
@endsection

@push('styles')
<style>
/* Красивый заголовок стадиона */
.stadium-header {
    text-align: center;
    margin: 16px 0 8px 0;
    padding: 24px;
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.stadium-title {
    font-size: 32px;
    font-weight: bold;
    color: #FFFFFF;
    margin: 0;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
}


/* Основной контейнер */
.main-content-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 24px;
    margin-bottom: 24px;
}

/* Блок основной информации */
.info-box {
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    padding: 24px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1), 0 1px 3px rgba(0,0,0,0.08);
    height: 100%;
    display: flex;
    flex-direction: column;
    transition: all 0.3s ease;
}

.info-box:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 12px rgba(0,0,0,0.15), 0 2px 6px rgba(0,0,0,0.1);
}

.info-box h4 {
    color: var(--text-primary);
    margin-bottom: 20px;
    font-size: 1.25rem;
    font-weight: 600;
    border-bottom: 1px solid var(--border-light);
    padding-bottom: 12px;
}

.info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    flex: 1;
}

.info-item {
    display: flex;
    flex-direction: column;
    padding: 12px 0;
}

.info-item.full-width {
    grid-column: 1 / -1;
}

.info-label {
    font-weight: 600;
    color: var(--text-secondary);
    font-size: 0.875rem;
    margin-bottom: 4px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.info-value {
    color: var(--text-primary);
    font-size: 1rem;
    word-break: break-word;
}

.info-value strong {
    font-weight: 700;
    color: var(--text-primary);
}

.badge {
    font-size: 0.875rem;
    padding: 6px 12px;
    border-radius: 6px;
}

/* Статистические карточки */
.stats-container {
    display: flex;
    flex-direction: column;
    gap: 16px;
    height: 100%;
}

.stats-card {
    background: #1F2937;
    border: 1px solid #374151;
    border-radius: 12px;
    padding: 16px;
    text-align: center;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1), 0 1px 3px rgba(0,0,0,0.08);
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
    min-height: 120px;
    transition: all 0.3s ease;
}

.stats-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 12px rgba(0,0,0,0.15), 0 2px 6px rgba(0,0,0,0.1);
}

.stats-number {
    font-size: 24px;
    font-weight: bold;
    color: #FFFFFF;
    margin-bottom: 8px;
    line-height: 1;
}

.stats-label {
    color: #9CA3AF;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 500;
}

/* Кнопки */
.action-buttons {
    display: flex;
    gap: 8px;
    justify-content: flex-start;
    margin-top: 24px;
}

.btn {
    padding: 8px 16px;
    border-radius: 6px;
    font-weight: 500;
    transition: all 0.2s ease;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

/* Адаптивность */
@media (max-width: 768px) {
    .stadium-header {
        margin: 8px 0;
        padding: 16px;
    }
    
    .stadium-title {
        font-size: 24px;
    }
    
    .main-content-grid {
        grid-template-columns: 1fr;
        gap: 16px;
    }

    .info-grid {
        grid-template-columns: 1fr;
    }

    .stats-container {
        flex-direction: row;
        flex-wrap: wrap;
    }

    .stats-card {
        flex: 1;
        min-width: calc(50% - 8px);
    }
}

/* Дополнительные стили для карточек */
.card {
    box-shadow: 0 4px 6px rgba(0,0,0,0.1), 0 1px 3px rgba(0,0,0,0.08);
    border-radius: 12px;
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 12px rgba(0,0,0,0.15), 0 2px 6px rgba(0,0,0,0.1);
}

.card-header {
    background: var(--bg-card);
    border-bottom: 1px solid var(--border-color);
    padding: 16px 20px;
}

.card-body {
    padding: 20px;
}

/* Таблицы */
.table {
    margin-bottom: 0;
}

.table th {
    background: var(--border-light);
    color: var(--text-primary);
    font-weight: 600;
    border-color: var(--border-color);
    padding: 12px;
}

.table td {
    border-color: var(--border-color);
    padding: 12px;
    vertical-align: middle;
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
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Красивый заголовок стадиона -->
            <div class="stadium-header">
                <h1 class="stadium-title">{{ $stadium->name }}</h1>
            </div>

            <!-- Основной контент с выравниванием -->
            <div class="main-content-grid">
                <!-- Основная информация -->
                <div class="info-box">
                    <h4>
                        <i class="fas fa-info-circle"></i>
                        Основная информация
                    </h4>

                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">ID</div>
                            <div class="info-value">{{ $stadium->id }}</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Название</div>
                            <div class="info-value">
                                <strong>{{ $stadium->name }}</strong>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Вместимость</div>
                            <div class="info-value">
                                <span class="badge badge-info">
                                    <i class="fas fa-users"></i>
                                    {{ number_format($stadium->total_capacity) }} мест
                                </span>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Дата создания</div>
                            <div class="info-value">{{ $stadium->created_at->format('d.m.Y H:i') }}</div>
                        </div>

                        <div class="info-item full-width">
                            <div class="info-label">Адрес</div>
                            <div class="info-value">{{ $stadium->address }}</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Последнее обновление</div>
                            <div class="info-value">{{ $stadium->updated_at->format('d.m.Y H:i') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Статистика -->
                <div class="stats-container">
                    <div class="stats-card">
                        <div class="stats-number">{{ number_format($stadium->total_capacity) }}</div>
                        <div class="stats-label">Вместимость</div>
                    </div>

                    <div class="stats-card">
                        <div class="stats-number">{{ $stadium->sectors->count() }}</div>
                        <div class="stats-label">Секторов</div>
                    </div>

                    <div class="stats-card">
                        <div class="stats-number">{{ $stadium->games->count() }}</div>
                        <div class="stats-label">Матчей</div>
                    </div>
                </div>
            </div>

            <!-- Связанные данные -->
            @if($stadium->sectors->count() > 0)
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-th-large"></i>
                                Секторы стадиона
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Название сектора</th>
                                            <th>Количество мест</th>
                                            <th>Дата создания</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($stadium->sectors as $sector)
                                        <tr>
                                            <td>{{ $sector->id }}</td>
                                            <td>{{ $sector->name }}</td>
                                            <td>
                                                <span class="badge badge-success">
                                                    {{ $sector->seats->count() }}
                                                </span>
                                            </td>
                                            <td>{{ $sector->created_at->format('d.m.Y H:i') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if($stadium->games->count() > 0)
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-futbol"></i>
                                Матчи на этом стадионе
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Название матча</th>
                                            <th>Команды</th>
                                            <th>Дата матча</th>
                                            <th>Статус</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($stadium->games as $game)
                                        <tr>
                                            <td>{{ $game->id }}</td>
                                            <td>{{ $game->title }}</td>
                                            <td>{{ $game->home_team_name }} vs {{ $game->away_team_name }}</td>
                                            <td>{{ $game->start_at->format('d.m.Y H:i') }}</td>
                                            <td>
                                                @switch($game->status)
                                                    @case('draft')
                                                        <span class="badge badge-secondary">Черновик</span>
                                                        @break
                                                    @case('ready')
                                                        <span class="badge badge-info">Готов</span>
                                                        @break
                                                    @case('tickets_open')
                                                        <span class="badge badge-success">Продажи открыты</span>
                                                        @break
                                                    @case('completed')
                                                        <span class="badge badge-primary">Завершен</span>
                                                        @break
                                                    @case('cancelled')
                                                        <span class="badge badge-danger">Отменен</span>
                                                        @break
                                                @endswitch
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Действия -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-cog"></i> Действия</h3>
                        </div>
                        <div class="card-body">
                            <!-- Кнопка "Назад" - сверху, белая с синей рамкой -->
                            <div class="mb-3">
                                <a href="{{ route('admin.stadiums.index') }}" class="btn btn-outline-primary btn-block">
                                    <i class="fa fa-arrow-left"></i> Назад к списку
                                </a>
                            </div>
                            
                            <!-- Кнопки "Редактировать" и "Удалить" - в одну строку -->
                            <div class="row">
                                <div class="col-6">
                                    <a href="{{ route('admin.stadiums.edit', $stadium) }}" class="btn btn-success btn-block">
                                        <i class="fa fa-edit"></i> Редактировать
                                    </a>
                                </div>
                                <div class="col-6">
                                    <form action="{{ route('admin.stadiums.destroy', $stadium) }}" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить этот стадион?')">
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
