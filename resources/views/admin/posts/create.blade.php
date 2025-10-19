@extends('admin.layouts.app')

@section('title', 'Создать новость')
@section('page-title', 'Создать новость')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.posts.index') }}">Новости</a></li>
    <li class="breadcrumb-item active">Создать</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Создать новость</h3>
                </div>
                <form action="{{ route('admin.posts.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Заголовок <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('title') is-invalid @enderror" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title') }}" 
                                   required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="excerpt">Краткое описание</label>
                            <textarea class="form-control @error('excerpt') is-invalid @enderror" 
                                      id="excerpt" 
                                      name="excerpt" 
                                      rows="3" 
                                      placeholder="Краткое описание новости...">{{ old('excerpt') }}</textarea>
                            @error('excerpt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="content">Содержание <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('content') is-invalid @enderror" 
                                      id="content" 
                                      name="content" 
                                      rows="10" 
                                      required 
                                      placeholder="Полное содержание новости...">{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="author_name">Автор</label>
                                    <input type="text" 
                                           class="form-control @error('author_name') is-invalid @enderror" 
                                           id="author_name" 
                                           name="author_name" 
                                           value="{{ old('author_name') }}" 
                                           placeholder="Имя автора">
                                    @error('author_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Статус <span class="text-danger">*</span></label>
                                    <select class="form-control @error('status') is-invalid @enderror" 
                                            id="status" 
                                            name="status" 
                                            required>
                                        <option value="">Выберите статус</option>
                                        <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Черновик</option>
                                        <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Опубликовать</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Создать новость
                        </button>
                        <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary ml-2">
                            <i class="fa fa-times"></i> Отмена
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Справка</h3>
                </div>
                <div class="card-body">
                    <h6>Статусы:</h6>
                    <ul class="list-unstyled">
                        <li><span class="badge badge-warning">Черновик</span> - новость не видна пользователям</li>
                        <li><span class="badge badge-success">Опубликовано</span> - новость доступна на сайте</li>
                    </ul>
                    
                    <h6 class="mt-3">Советы:</h6>
                    <ul>
                        <li>Заголовок должен быть информативным</li>
                        <li>Краткое описание поможет в поиске</li>
                        <li>Используйте абзацы для лучшей читаемости</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Автоматическое заполнение поля "Автор" именем текущего пользователя
    document.addEventListener('DOMContentLoaded', function() {
        const authorField = document.getElementById('author_name');
        if (!authorField.value) {
            authorField.value = '{{ auth()->user()->name }}';
        }
    });
</script>
@endpush

