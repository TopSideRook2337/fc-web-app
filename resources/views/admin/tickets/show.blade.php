@extends('admin.layouts.app')

@section('title', 'Просмотр билета #' . $ticket->id)
@section('page-title', 'Билет #' . $ticket->id)

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.tickets.index') }}">Билеты</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.tickets.game-tickets', $ticket->game) }}">Билеты на матч #{{ $ticket->game->id }}</a></li>
    <li class="breadcrumb-item active">Билет #{{ $ticket->id }}</li>
@endsection

@push('styles')
<style>
.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 0.25rem;
    font-weight: 500;
    font-size: 1rem;
}
.status-reserved { background-color: #D97706; color: #FFFFFF; }
.status-paid { background-color: #059669; color: #FFFFFF; }
.status-used { background-color: #6366F1; color: #FFFFFF; }
.status-cancelled { background-color: #DC2626; color: #FFFFFF; }

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

.info-table tr:last-child td {
    border-bottom: none;
}

.qr-code-container {
    text-align: center;
    padding: 1.5rem;
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
}

.qr-code-container img {
    max-width: 300px;
    height: auto;
    border: 2px solid var(--border-color);
    border-radius: 8px;
    padding: 10px;
    background: #FFFFFF;
}

.actions-box {
    background: #1F2937;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
    padding: 16px;
    margin-bottom: 1.5rem;
}

.actions-title {
    margin-bottom: 1rem;
    font-weight: 600;
    color: #FFFFFF;
    font-size: 1.1rem;
}

.actions-title i {
    color: #9CA3AF;
    margin-right: 0.5rem;
}

.actions-buttons {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.action-btn {
    display: inline-flex;
    align-items: center;
    padding: 8px 16px;
    border-radius: 6px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s ease;
    font-size: 0.95rem;
}

.action-btn i {
    margin-right: 8px;
}

.action-btn-secondary {
    background-color: #4B5563;
    color: #FFFFFF;
}

.action-btn-secondary:hover {
    background-color: #6B7280;
    color: #FFFFFF;
    text-decoration: none;
}

.action-btn-primary {
    background-color: #3B82F6;
    color: #FFFFFF;
}

.action-btn-primary:hover {
    background-color: #2563EB;
    color: #FFFFFF;
    text-decoration: none;
}
</style>
@endpush

@section('content')
    <div class="row">
        <!-- Левая колонка -->
        <div class="col-md-8">
            <!-- Информация о билете -->
            <div class="info-box">
                <h5><i class="fas fa-ticket-alt"></i> Информация о билете</h5>
                <table class="info-table">
                    <tr>
                        <td>ID билета:</td>
                        <td>{{ $ticket->id }}</td>
                    </tr>
                    <tr>
                        <td>Статус:</td>
                        <td>
                            @php
                                $statusConfig = [
                                    'reserved' => ['text' => 'Забронирован', 'class' => 'status-reserved'],
                                    'paid' => ['text' => 'Оплачен', 'class' => 'status-paid'],
                                    'used' => ['text' => 'Использован', 'class' => 'status-used'],
                                    'cancelled' => ['text' => 'Отменён', 'class' => 'status-cancelled'],
                                ];
                                $status = $statusConfig[$ticket->status] ?? ['text' => $ticket->status, 'class' => 'status-reserved'];
                            @endphp
                            <span class="status-badge {{ $status['class'] }}">{{ $status['text'] }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td>Дата создания:</td>
                        <td>{{ $ticket->created_at->format('d.m.Y H:i') }}</td>
                    </tr>
                    @if($ticket->reservation_expires_at)
                    <tr>
                        <td>Истекает бронь:</td>
                        <td>{{ $ticket->reservation_expires_at->format('d.m.Y H:i') }}</td>
                    </tr>
                    @endif
                </table>
            </div>

            <!-- Информация о матче -->
            <div class="info-box">
                <h5><i class="fas fa-futbol"></i> Информация о матче</h5>
                <table class="info-table">
                    <tr>
                        <td>Матч:</td>
                        <td>{{ $ticket->game->title }}</td>
                    </tr>
                    <tr>
                        <td>Команды:</td>
                        <td>{{ $ticket->game->home_team_name }} vs {{ $ticket->game->away_team_name }}</td>
                    </tr>
                    <tr>
                        <td>Дата и время:</td>
                        <td>{{ $ticket->game->start_at->format('d.m.Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td>Стадион:</td>
                        <td>{{ $ticket->game->stadium->name }}</td>
                    </tr>
                    <tr>
                        <td>Адрес:</td>
                        <td>{{ $ticket->game->stadium->address }}</td>
                    </tr>
                </table>
            </div>

            <!-- Информация о месте -->
            <div class="info-box">
                <h5><i class="fas fa-chair"></i> Информация о месте</h5>
                <table class="info-table">
                    <tr>
                        <td>Сектор:</td>
                        <td>{{ $ticket->seat->sector->name }}</td>
                    </tr>
                    <tr>
                        <td>Ряд:</td>
                        <td>{{ $ticket->seat->row }}</td>
                    </tr>
                    <tr>
                        <td>Место:</td>
                        <td>{{ $ticket->seat->number }}</td>
                    </tr>
                    <tr>
                        <td>Цена:</td>
                        <td>{{ number_format($ticket->seat->sector->price_per_seat, 2, ',', ' ') }} ₽</td>
                    </tr>
                </table>
            </div>

            <!-- Информация о заказе -->
            @if($ticket->order)
            <div class="info-box">
                <h5><i class="fas fa-shopping-cart"></i> Информация о заказе</h5>
                <table class="info-table">
                    <tr>
                        <td>Заказ:</td>
                        <td>
                            <a href="{{ route('admin.orders.show', $ticket->order) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i> Заказ #{{ $ticket->order->id }}
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>Покупатель:</td>
                        <td>
                            @if($ticket->order->user)
                                {{ $ticket->order->user->name }} ({{ $ticket->order->user->email }})
                            @else
                                <span class="text-muted">Гость</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Статус заказа:</td>
                        <td>
                            @php
                                $orderStatusConfig = [
                                    'cart' => ['text' => 'Корзина', 'class' => 'badge badge-secondary'],
                                    'pending' => ['text' => 'Ожидает оплаты', 'class' => 'badge badge-warning'],
                                    'paid' => ['text' => 'Оплачен', 'class' => 'badge badge-success'],
                                    'cancelled' => ['text' => 'Отменён', 'class' => 'badge badge-danger'],
                                    'expired' => ['text' => 'Истёк', 'class' => 'badge badge-secondary'],
                                ];
                                $orderStatus = $orderStatusConfig[$ticket->order->status] ?? ['text' => $ticket->order->status, 'class' => 'badge badge-secondary'];
                            @endphp
                            <span class="{{ $orderStatus['class'] }}">{{ $orderStatus['text'] }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td>Сумма заказа:</td>
                        <td>{{ number_format($ticket->order->total_amount, 2, ',', ' ') }} {{ $ticket->order->currency }}</td>
                    </tr>
                    @if($ticket->order->paid_at)
                    <tr>
                        <td>Дата оплаты:</td>
                        <td>{{ $ticket->order->paid_at->format('d.m.Y H:i') }}</td>
                    </tr>
                    @endif
                </table>
            </div>
            @endif
        </div>

        <!-- Правая колонка -->
        <div class="col-md-4">
            <!-- QR-код -->
            @if($ticket->qr_code_path)
            <div class="qr-code-container mb-3">
                <h5 class="mb-3"><i class="fas fa-qrcode"></i> QR-код билета</h5>
                <img src="{{ Storage::url($ticket->qr_code_path) }}" alt="QR-код билета #{{ $ticket->id }}">
                <p class="text-muted mt-3 mb-0">Предъявите этот код на входе</p>
            </div>
            @else
            <div class="qr-code-container mb-3">
                <h5 class="mb-3"><i class="fas fa-qrcode"></i> QR-код</h5>
                <p class="text-muted">QR-код ещё не сгенерирован</p>
                <small class="text-muted">QR-код генерируется после оплаты заказа</small>
            </div>
            @endif

            <!-- Действия -->
            <div class="actions-box">
                <h5 class="actions-title"><i class="fas fa-cog"></i> Действия</h5>
                <div class="actions-buttons">
                    <a href="{{ route('admin.tickets.game-tickets', $ticket->game) }}" class="action-btn action-btn-secondary">
                        <i class="fas fa-arrow-left"></i> Назад к списку билетов
                    </a>
                    @if($ticket->order)
                    <a href="{{ route('admin.orders.show', $ticket->order) }}" class="action-btn action-btn-primary">
                        <i class="fas fa-shopping-cart"></i> Просмотр заказа
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

