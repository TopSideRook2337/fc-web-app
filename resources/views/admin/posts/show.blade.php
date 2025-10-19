@extends('admin.layouts.app')

@section('title', 'Просмотр новости')
@section('page-title', 'Просмотр новости')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.posts.index') }}">Новости</a></li>
    <li class="breadcrumb-item active">{{ $post->title }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $post->title }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-warning btn-sm">
                            <i class="fa fa-edit"></i> Редактировать
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Статус:</strong>
                            <span class="badge badge-{{ $post->status === 'published' ? 'success' : 'warning' }} ml-2">
                                {{ $post->status === 'published' ? 'Опубликовано' : 'Черновик' }}
                            </span>
                        </div>
                        <div class="col-md-6">
                            <strong>Автор:</strong> {{ $post->author_name ?? 'Не указан' }}
                        </div>
                    </div>

                    @if($post->excerpt)
                        <div class="mb-3">
                            <strong>Краткое описание:</strong>
                            <p class="mt-2">{{ $post->excerpt }}</p>
                        </div>
                    @endif

                    <div class="mb-3">
                        <strong>Содержание:</strong>
                        <div class="mt-2 p-3 bg-light rounded">
                            {!! nl2br(e($post->content)) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <strong>Дата создания:</strong> {{ $post->created_at ? $post->created_at->format('d.m.Y H:i') : 'Не указано' }}
                        </div>
                        <div class="col-md-6">
                            <strong>Дата публикации:</strong> 
                            {{ $post->published_at ? $post->published_at->format('d.m.Y H:i') : 'Не опубликовано' }}
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
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-warning">
                            <i class="fa fa-edit"></i> Редактировать
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

            <div class="card mt-3">
                <div class="card-header">
                    <h3 class="card-title">Информация</h3>
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
                            <td><strong>Обновлено:</strong></td>
                            <td>{{ $post->updated_at->format('d.m.Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

