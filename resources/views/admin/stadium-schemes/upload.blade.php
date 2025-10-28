@extends('admin.layouts.app')

@section('title', 'Загрузка схемы стадиона')
@section('page-title', 'Загрузка схемы стадиона')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.stadium-schemes.index') }}">Схемы стадионов</a></li>
    <li class="breadcrumb-item active">Загрузка схемы</li>
@endsection

@push('styles')
<style>
.schemes-card {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
}

.schemes-card-header {
    background: var(--card-bg);
    border-bottom: 1px solid var(--border-color);
    color: var(--text-primary);
    padding: 16px;
}

.schemes-card-body {
    background: var(--card-bg);
    padding: 16px;
}

.schemes-card-footer {
    background: var(--card-bg);
    border-top: 1px solid var(--border-color);
    padding: 16px;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    color: var(--text-primary);
    margin-bottom: 0.5rem;
    display: block;
    font-weight: 500;
}

.form-group label i {
    color: #9CA3AF;
    margin-right: 0.5rem;
}

.form-control {
    background: var(--input-bg);
    border: 1px solid var(--border-color);
    color: var(--text-primary);
    border-radius: 4px;
    padding: 0.5rem 0.75rem;
    width: 100%;
}

.form-control:focus {
    background: var(--input-bg);
    border-color: #3B82F6;
    color: var(--text-primary);
    outline: none;
}

.form-control.is-invalid {
    border-color: #DC2626;
}

.custom-file-input {
    position: relative;
    z-index: 2;
    width: 100%;
    height: calc(2.25rem + 2px);
    margin: 0;
    opacity: 0;
}

.custom-file-label {
    position: absolute;
    top: 0;
    right: 0;
    left: 0;
    z-index: 1;
    height: calc(2.25rem + 2px);
    padding: 0.5rem 0.75rem;
    line-height: 1.5;
    color: var(--text-primary);
    background-color: var(--input-bg);
    border: 1px solid var(--border-color);
    border-radius: 4px;
}

.custom-file {
    position: relative;
    display: inline-block;
    width: 100%;
    height: calc(2.25rem + 2px);
    margin-bottom: 0;
}

.invalid-feedback {
    color: #DC2626;
    font-size: 0.875rem;
    margin-top: 0.25rem;
    display: block;
}

.form-text {
    color: #9CA3AF;
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

.form-text i {
    color: #9CA3AF;
    margin-right: 0.25rem;
}

.alert-info {
    background-color: rgba(59, 130, 246, 0.1);
    border: 1px solid #3B82F6;
    color: var(--text-primary);
    padding: 1rem;
    border-radius: 4px;
    margin-top: 1rem;
}

.alert-info i {
    color: #3B82F6;
    margin-right: 0.5rem;
}

.alert-info code {
    background-color: rgba(0, 0, 0, 0.3);
    color: #3B82F6;
    padding: 0.2rem 0.4rem;
    border-radius: 3px;
}

.btn-secondary {
    background-color: #6B7280;
    border-color: #6B7280;
    color: #FFFFFF;
    padding: 0.5rem 1rem;
    border-radius: 4px;
    text-decoration: none;
    display: inline-block;
    border: none;
}

.btn-secondary:hover {
    background-color: #4B5563;
    border-color: #4B5563;
    color: #FFFFFF;
    text-decoration: none;
}

.btn-primary {
    background-color: #3B82F6;
    border-color: #3B82F6;
    color: #FFFFFF;
    padding: 0.5rem 1rem;
    border-radius: 4px;
    text-decoration: none;
    display: inline-block;
    border: none;
    cursor: pointer;
}

.btn-primary:hover {
    background-color: #2563EB;
    border-color: #2563EB;
    color: #FFFFFF;
    text-decoration: none;
}

.list-unstyled {
    list-style: none;
    padding-left: 0;
}

.list-unstyled li {
    margin-bottom: 0.5rem;
    color: var(--text-primary);
}

.list-unstyled li i {
    margin-right: 0.5rem;
}

.text-success {
    color: #059669 !important;
}

pre {
    background-color: rgba(0, 0, 0, 0.3);
    border: 1px solid var(--border-color);
    padding: 0.75rem;
    border-radius: 4px;
    color: #9CA3AF;
}

pre code {
    color: #9CA3AF;
}

h5 {
    color: var(--text-primary);
    font-weight: 600;
    margin-bottom: 1rem;
}
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="schemes-card">
            <div class="schemes-card-header">
                <h3 style="margin: 0; font-size: 1.25rem; font-weight: 600;">
                    <i class="fas fa-upload" style="color: #9CA3AF; margin-right: 0.5rem;"></i>
                    Загрузка SVG схемы
                </h3>
            </div>
            <form action="{{ route('admin.stadium-schemes.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="schemes-card-body">
                    <div class="form-group">
                        <label for="stadium_id">
                            <i class="fas fa-building"></i>
                            Выберите стадион
                        </label>
                        <select name="stadium_id" id="stadium_id" class="form-control @error('stadium_id') is-invalid @enderror" required>
                            <option value="">-- Выберите стадион --</option>
                            @foreach($stadiums as $stadium)
                                <option value="{{ $stadium->id }}" {{ old('stadium_id') == $stadium->id ? 'selected' : '' }}>
                                    {{ $stadium->name }} ({{ $stadium->address }})
                                </option>
                            @endforeach
                        </select>
                        @error('stadium_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="svg">
                            <i class="fas fa-file-image"></i>
                            SVG файл схемы
                        </label>
                        <div class="custom-file">
                            <input type="file" 
                                   class="custom-file-input @error('svg') is-invalid @enderror" 
                                   id="svg" 
                                   name="svg" 
                                   accept=".svg"
                                   required>
                            <label class="custom-file-label" for="svg">Выберите SVG файл</label>
                        </div>
                        @error('svg')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text">
                            <i class="fas fa-info-circle"></i>
                            Поддерживаются только файлы в формате SVG. Максимальный размер: 10MB.
                        </small>
                    </div>

                    <div class="alert-info">
                        <i class="fas fa-lightbulb"></i>
                        <strong>Совет:</strong> Убедитесь, что SVG файл содержит элементы с атрибутом <code>data-sector</code> 
                        для корректной привязки секторов к схеме.
                    </div>
                </div>
                <div class="schemes-card-footer">
                    <div style="display: flex; justify-content: space-between;">
                        <a href="{{ route('admin.stadium-schemes.index') }}" class="btn-secondary">
                            <i class="fas fa-arrow-left" style="margin-right: 0.5rem;"></i>
                            Назад к списку
                        </a>
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-upload" style="margin-right: 0.5rem;"></i>
                            Загрузить схему
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-4">
        <div class="schemes-card">
            <div class="schemes-card-header">
                <h3 style="margin: 0; font-size: 1.25rem; font-weight: 600;">
                    <i class="fas fa-info-circle" style="color: #9CA3AF; margin-right: 0.5rem;"></i>
                    Информация
                </h3>
            </div>
            <div class="schemes-card-body">
                <h5>Требования к SVG файлу:</h5>
                <ul class="list-unstyled">
                    <li><i class="fas fa-check text-success"></i> Формат: SVG</li>
                    <li><i class="fas fa-check text-success"></i> Размер: до 10MB</li>
                    <li><i class="fas fa-check text-success"></i> Атрибуты: data-sector</li>
                </ul>
                
                <h5 style="margin-top: 1.5rem;">Пример структуры:</h5>
                <pre><code>&lt;rect data-sector="A" 
     x="100" y="50" 
     width="200" height="100" /&gt;</code></pre>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('svg');
    const fileLabel = fileInput.nextElementSibling;
    
    fileInput.addEventListener('change', function() {
        if (this.files.length > 0) {
            fileLabel.textContent = this.files[0].name;
        } else {
            fileLabel.textContent = 'Выберите SVG файл';
        }
    });
});
</script>
@endpush
