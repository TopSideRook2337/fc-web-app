@extends('admin.layouts.app')

@section('title', 'Просмотр новости')
@section('page-title', 'Просмотр новости')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.posts.index') }}">Новости</a></li>
    <li class="breadcrumb-item active">{{ $post->title }}</li>
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
</style>
@endpush

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
                    <h3 class="card-title"><i class="fas fa-cog"></i> Действия</h3>
                </div>
                <div class="card-body">
                    <!-- Кнопка "Назад" - сверху, белая с синей рамкой -->
                    <div class="mb-3">
                        <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-primary btn-block">
                            <i class="fa fa-arrow-left"></i> Назад к списку
                        </a>
                    </div>
                    
                    <!-- Кнопки "Редактировать" и "Удалить" - в одну строку -->
                    <div class="row">
                        <div class="col-6">
                            <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-success btn-block">
                                <i class="fa fa-edit"></i> Редактировать
                            </a>
                        </div>
                        <div class="col-6">
                            <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить эту новость?')">
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

