@extends('admin.layouts.app')

@section('title', 'Редактировать матч')
@section('page-title', 'Редактировать матч')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.games.index') }}">Матчи</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.games.show', $game) }}">{{ $game->title }}</a></li>
    <li class="breadcrumb-item active">Редактировать</li>
@endsection

@push('styles')
<style>
.team-logo-preview {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 50%;
    border: 2px solid #dee2e6;
}
.logo-placeholder {
    width: 60px;
    height: 60px;
    border: 2px dashed #dee2e6;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #f8f9fa;
}
.current-logo {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 50%;
    border: 2px solid #28a745;
}
</style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Редактировать матч</h3>
                </div>
                <form action="{{ route('admin.games.update', $game) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Название матча <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('title') is-invalid @enderror" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title', $game->title) }}" 
                                   placeholder="Например: Дерби Реал - Барселона"
                                   required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="team_home">Домашняя команда <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('home_team_name') is-invalid @enderror" 
                                           id="home_team_name" 
                                           name="home_team_name" 
                                           value="{{ old('home_team_name', $game->home_team_name) }}" 
                                           placeholder="Название команды"
                                           required>
                                    @error('home_team_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="team_away">Гостевая команда <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('away_team_name') is-invalid @enderror" 
                                           id="away_team_name" 
                                           name="away_team_name" 
                                           value="{{ old('away_team_name', $game->away_team_name) }}" 
                                           placeholder="Название команды"
                                           required>
                                    @error('away_team_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="team_home_logo">Логотип домашней команды</label>
                                    @if($game->home_team_logo_path)
                                        <div class="mb-2">
                                            <small class="text-muted">Текущий логотип:</small><br>
                                            <img src="{{ asset('storage/' . $game->home_team_logo_path) }}" alt="{{ $game->home_team_name }}" class="current-logo">
                                        </div>
                                    @endif
                                    <div class="custom-file">
                                        <input type="file" 
                                               class="custom-file-input @error('home_team_logo') is-invalid @enderror" 
                                               id="home_team_logo" 
                                               name="home_team_logo"
                                               accept="image/*"
                                               onchange="previewLogo(this, 'home-preview')">
                                        <label class="custom-file-label" for="home_team_logo">Выберите новый файл</label>
                                    </div>
                                    @error('home_team_logo')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                    <div class="mt-2">
                                        <div id="home-preview" class="logo-placeholder">
                                            <i class="fa fa-image text-muted"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="team_away_logo">Логотип гостевой команды</label>
                                    @if($game->away_team_logo_path)
                                        <div class="mb-2">
                                            <small class="text-muted">Текущий логотип:</small><br>
                                            <img src="{{ asset('storage/' . $game->away_team_logo_path) }}" alt="{{ $game->away_team_name }}" class="current-logo">
                                        </div>
                                    @endif
                                    <div class="custom-file">
                                        <input type="file" 
                                               class="custom-file-input @error('away_team_logo') is-invalid @enderror" 
                                               id="away_team_logo" 
                                               name="away_team_logo"
                                               accept="image/*"
                                               onchange="previewLogo(this, 'away-preview')">
                                        <label class="custom-file-label" for="away_team_logo">Выберите новый файл</label>
                                    </div>
                                    @error('away_team_logo')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                    <div class="mt-2">
                                        <div id="away-preview" class="logo-placeholder">
                                            <i class="fa fa-image text-muted"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="start_at">Дата и время матча <span class="text-danger">*</span></label>
                                    <input type="datetime-local" 
                                           class="form-control @error('start_at') is-invalid @enderror" 
                                           id="start_at" 
                                           name="start_at" 
                                           value="{{ old('start_at', $game->start_at ? $game->start_at->format('Y-m-d\TH:i') : '') }}" 
                                           required>
                                    @error('start_at')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="stadium_id">Стадион <span class="text-danger">*</span></label>
                                    <select class="form-control @error('stadium_id') is-invalid @enderror" 
                                            id="stadium_id" 
                                            name="stadium_id" 
                                            required>
                                        <option value="">Выберите стадион</option>
                                        @foreach($stadiums as $stadium)
                                            <option value="{{ $stadium->id }}" {{ old('stadium_id', $game->stadium_id) == $stadium->id ? 'selected' : '' }}>
                                                {{ $stadium->name }} ({{ $stadium->total_capacity }} мест)
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('stadium_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="status">Статус матча</label>
                            <select class="form-control @error('status') is-invalid @enderror" 
                                    id="status" 
                                    name="status">
                                <option value="draft" {{ old('status', $game->status) == 'draft' ? 'selected' : '' }}>Черновик</option>
                                <option value="ready" {{ old('status', $game->status) == 'ready' ? 'selected' : '' }}>Готов</option>
                                <option value="tickets_open" {{ old('status', $game->status) == 'tickets_open' ? 'selected' : '' }}>Продажи открыты</option>
                                <option value="completed" {{ old('status', $game->status) == 'completed' ? 'selected' : '' }}>Завершен</option>
                                <option value="cancelled" {{ old('status', $game->status) == 'cancelled' ? 'selected' : '' }}>Отменен</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Сохранить изменения
                        </button>
                        <a href="{{ route('admin.games.show', $game) }}" class="btn btn-secondary ml-2">
                            <i class="fa fa-times"></i> Отмена
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Информация о матче</h3>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <td><strong>ID:</strong></td>
                            <td>{{ $game->id }}</td>
                        </tr>
                        <tr>
                            <td><strong>Создан:</strong></td>
                            <td>{{ $game->created_at ? $game->created_at->format('d.m.Y H:i') : 'Не указано' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Обновлен:</strong></td>
                            <td>{{ $game->updated_at ? $game->updated_at->format('d.m.Y H:i') : 'Не указано' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Статус продаж:</strong></td>
                            <td>
                                <span class="badge badge-{{ $game->tickets_available ? 'success' : 'warning' }}">
                                    {{ $game->tickets_available ? 'Открыты' : 'Закрыты' }}
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h3 class="card-title">Действия</h3>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.games.show', $game) }}" class="btn btn-info">
                            <i class="fa fa-eye"></i> Просмотр
                        </a>
                        <a href="{{ route('admin.games.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Назад к списку
                        </a>
                        <form action="{{ route('admin.games.destroy', $game) }}" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить этот матч?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fa fa-trash"></i> Удалить
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function previewLogo(input, previewId) {
        const preview = document.getElementById(previewId);
        const file = input.files[0];
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = `<img src="${e.target.result}" class="team-logo-preview" alt="Preview">`;
            };
            reader.readAsDataURL(file);
        } else {
            preview.innerHTML = '<i class="fa fa-image text-muted"></i>';
        }
    }

    // Обновление label для файловых полей
    document.querySelectorAll('.custom-file-input').forEach(input => {
        input.addEventListener('change', function() {
            const label = this.nextElementSibling;
            const fileName = this.files[0] ? this.files[0].name : 'Выберите файл';
            label.textContent = fileName;
        });
    });
</script>
@endpush
