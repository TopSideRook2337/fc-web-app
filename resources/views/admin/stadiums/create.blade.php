@extends('admin.layouts.app')

@section('title', 'Создать стадион')
@section('page-title', 'Создание нового стадиона')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.stadiums.index') }}">Стадионы</a></li>
    <li class="breadcrumb-item active">Создать</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-plus"></i>
                        Создание нового стадиона
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.stadiums.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i>
                            Назад к списку
                        </a>
                    </div>
                </div>

                <form action="{{ route('admin.stadiums.store') }}" method="POST">
                    @csrf

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Название стадиона <span class="text-danger">*</span></label>
                                    <input type="text"
                                           class="form-control @error('name') is-invalid @enderror"
                                           id="name"
                                           name="name"
                                           value="{{ old('name') }}"
                                           placeholder="Введите название стадиона"
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="total_capacity">Вместимость <span class="text-danger">*</span></label>
                                    <input type="number"
                                           class="form-control @error('total_capacity') is-invalid @enderror"
                                           id="total_capacity"
                                           name="total_capacity"
                                           value="{{ old('total_capacity') }}"
                                           placeholder="Введите вместимость стадиона"
                                           min="1"
                                           required>
                                    @error('total_capacity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="address">Адрес стадиона <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('address') is-invalid @enderror"
                                              id="address"
                                              name="address"
                                              rows="3"
                                              placeholder="Введите полный адрес стадиона"
                                              required>{{ old('address') }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-12">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save"></i>
                                        Создать стадион
                                    </button>
                                    <a href="{{ route('admin.stadiums.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times"></i>
                                        Отмена
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
