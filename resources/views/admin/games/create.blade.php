@extends('admin.layouts.app')

@section('title', 'Создать матч')
@section('page-title', 'Создать матч')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.games.index') }}">Матчи</a></li>
    <li class="breadcrumb-item active">Создать</li>
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
</style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Создать матч</h3>
                </div>
                <form action="{{ route('admin.games.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Название матча <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('title') is-invalid @enderror"
                                   id="title"
                                   name="title"
                                   value="{{ old('title') }}"
                                   placeholder="Например: Дерби Реал - Барселона"
                                   required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="home_team_name">Домашняя команда <span class="text-danger">*</span></label>
                                    <input type="text"
                                           class="form-control @error('home_team_name') is-invalid @enderror"
                                           id="home_team_name"
                                           name="home_team_name"
                                           value="{{ old('home_team_name') }}"
                                           placeholder="Название команды"
                                           required>
                                    @error('home_team_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="away_team_name">Гостевая команда <span class="text-danger">*</span></label>
                                    <input type="text"
                                           class="form-control @error('away_team_name') is-invalid @enderror"
                                           id="away_team_name"
                                           name="away_team_name"
                                           value="{{ old('away_team_name') }}"
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
                                    <label for="home_team_logo">Логотип домашней команды</label>
                                    <div class="custom-file">
                                        <input type="file"
                                               class="custom-file-input @error('home_team_logo') is-invalid @enderror"
                                               id="home_team_logo"
                                               name="home_team_logo"
                                               accept="image/*"
                                               onchange="previewLogo(this, 'home-preview')">
                                        <label class="custom-file-label" for="home_team_logo">Выберите файл</label>
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
                                    <label for="away_team_logo">Логотип гостевой команды</label>
                                    <div class="custom-file">
                                        <input type="file"
                                               class="custom-file-input @error('away_team_logo') is-invalid @enderror"
                                               id="away_team_logo"
                                               name="away_team_logo"
                                               accept="image/*"
                                               onchange="previewLogo(this, 'away-preview')">
                                        <label class="custom-file-label" for="away_team_logo">Выберите файл</label>
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
                                           value="{{ old('start_at') }}"
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
                                            <option value="{{ $stadium->id }}" {{ old('stadium_id') == $stadium->id ? 'selected' : '' }}>
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
                                <option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>Черновик</option>
                                <option value="ready" {{ old('status') == 'ready' ? 'selected' : '' }}>Готов</option>
                                <option value="tickets_open" {{ old('status') == 'tickets_open' ? 'selected' : '' }}>Продажи открыты</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Создать матч
                        </button>
                        <a href="{{ route('admin.games.index') }}" class="btn btn-secondary ml-2">
                            <i class="fa fa-times"></i> Отмена
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Информация</h3>
                </div>
                <div class="card-body">
                    <h5>Создание матча</h5>
                    <p class="text-muted">
                        Заполните все обязательные поля для создания нового матча.
                        После создания матч появится в списке и будет доступен для покупки билетов (если продажи открыты).
                    </p>

                    <h6>Логотипы команд</h6>
                    <p class="text-muted">
                        Загрузите изображения логотипов команд. Поддерживаются форматы:
                        JPEG, PNG, JPG, GIF, SVG. Максимальный размер: 2MB.
                    </p>

                    <h6>Статус продаж</h6>
                    <p class="text-muted">
                        Вы можете открыть или закрыть продажу билетов на матч в любое время
                        через форму редактирования.
                    </p>
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
