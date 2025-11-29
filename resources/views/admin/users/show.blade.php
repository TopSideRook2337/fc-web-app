@extends('admin.layouts.app')

@section('title', 'Просмотр пользователя')
@section('page-title', 'Просмотр пользователя')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Пользователи</a></li>
    <li class="breadcrumb-item active">{{ $user->name }}</li>
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

.info-card {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 0.25rem;
    margin-bottom: 1rem;
}

.info-card h5 {
    font-size: 0.9rem;
    color: #6c757d;
    margin-bottom: 0.5rem;
}

.info-card p {
    font-size: 1.1rem;
    font-weight: 500;
    margin: 0;
}
</style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $user->name }}</h3>
                    @if(auth()->user()->role === 'admin')
                    <div class="card-tools">
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning btn-sm">
                            <i class="fa fa-edit"></i> Редактировать
                        </a>
                    </div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>ID:</strong> {{ $user->id }}
                        </div>
                        <div class="col-md-6">
                            <strong>Email:</strong> {{ $user->email }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Роль:</strong>
                            @php
                                $roleConfig = [
                                    'admin' => ['badge' => 'danger', 'icon' => 'user-shield', 'label' => 'Администратор'],
                                    'manager' => ['badge' => 'warning', 'icon' => 'user-tie', 'label' => 'Менеджер'],
                                    'user' => ['badge' => 'info', 'icon' => 'user', 'label' => 'Пользователь'],
                                ];
                                $config = $roleConfig[$user->role] ?? ['badge' => 'secondary', 'icon' => 'user', 'label' => 'Неизвестно'];
                            @endphp
                            <span class="badge badge-{{ $config['badge'] }} ml-2">
                                <i class="fa fa-{{ $config['icon'] }}"></i>
                                {{ $config['label'] }}
                            </span>
                        </div>
                        <div class="col-md-6">
                            <strong>Дата регистрации:</strong> {{ $user->created_at ? $user->created_at->format('d.m.Y H:i') : 'Не указано' }}
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-card">
                                <h5>Заказов</h5>
                                <p>{{ $ordersCount }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-card">
                                <h5>Билетов</h5>
                                <p>{{ $ticketsCount }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <a href="{{ route('admin.orders.index', ['user_id' => $user->id]) }}" class="btn btn-info btn-block">
                                <i class="fa fa-shopping-cart"></i> Просмотреть заказы
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('admin.tickets.index', ['user_id' => $user->id]) }}" class="btn btn-primary btn-block">
                                <i class="fa fa-ticket-alt"></i> Просмотреть билеты
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-cog"></i> Действия</h3>
                </div>
                <div class="card-body">
                    <!-- Кнопка "Назад" - сверху, белая с синей рамкой -->
                    <div class="mb-3">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary btn-block">
                            <i class="fa fa-arrow-left"></i> Назад к списку
                        </a>
                    </div>
                    
                    @if(auth()->user()->role === 'admin')
                    <!-- Кнопки "Редактировать" и "Удалить" - в одну строку -->
                    <div class="row">
                        <div class="col-6">
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-success btn-block">
                                <i class="fa fa-edit"></i> Редактировать
                            </a>
                        </div>
                        <div class="col-6">
                            @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить этого пользователя?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-block">
                                    <i class="fa fa-trash"></i> Удалить
                                </button>
                            </form>
                            @else
                            <button type="button" class="btn btn-secondary btn-block" disabled title="Нельзя удалить собственный аккаунт">
                                <i class="fa fa-ban"></i> Удалить
                            </button>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection







