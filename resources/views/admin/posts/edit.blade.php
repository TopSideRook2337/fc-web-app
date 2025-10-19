@extends('admin.layouts.app')

@section('title', 'Редактировать новость')
@section('page-title', 'Редактировать новость')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.posts.index') }}">Новости</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.posts.show', $post) }}">{{ $post->title }}</a></li>
    <li class="breadcrumb-item active">Редактировать</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Редактировать новость</h3>
                </div>
                <form action="{{ route('admin.posts.update', $post) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Заголовок <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('title') is-invalid @enderror" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title', $post->title) }}" 
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
                                      placeholder="Краткое описание новости...">{{ old('excerpt', $post->excerpt) }}</textarea>
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
                                      placeholder="Полное содержание новости...">{{ old('content', $post->content) }}</textarea>
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
                                           value="{{ old('author_name', $post->author_name) }}" 
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
                                        <option value="draft" {{ old('status', $post->status) === 'draft' ? 'selected' : '' }}>Черновик</option>
                                        <option value="published" {{ old('status', $post->status) === 'published' ? 'selected' : '' }}>Опубликовать</option>
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
                            <i class="fa fa-save"></i> Сохранить изменения
                        </button>
                        <a href="{{ route('admin.posts.show', $post) }}" class="btn btn-secondary ml-2">
                            <i class="fa fa-times"></i> Отмена
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Информация о новости</h3>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <td><strong>ID:</strong></td>
                            <td>{{ $post->id }}</td>
                        </tr>
                        <tr>
                            <td><strong>Slug:</strong></td>
                            <td><code>{{ $post->slug }}</code></td>
                        </tr>
                        <tr>
                            <td><strong>Создано:</strong></td>
                            <td>{{ $post->created_at ? $post->created_at->format('d.m.Y H:i') : 'Не указано' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Обновлено:</strong></td>
                            <td>{{ $post->updated_at ? $post->updated_at->format('d.m.Y H:i') : 'Не указано' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Опубликовано:</strong></td>
                            <td>{{ $post->published_at ? $post->published_at->format('d.m.Y H:i') : 'Не опубликовано' }}</td>
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
                        <a href="{{ route('admin.posts.show', $post) }}" class="btn btn-info">
                            <i class="fa fa-eye"></i> Просмотр
                        </a>
                        <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Назад к списку
                        </a>
                        <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить эту новость?')">
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

