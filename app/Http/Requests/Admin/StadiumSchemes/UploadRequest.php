<?php

namespace App\Http\Requests\Admin\StadiumSchemes;

use Illuminate\Foundation\Http\FormRequest;

class UploadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'stadium_id' => 'required|exists:stadiums,id',
            'svg' => 'required|file|mimes:svg|max:10240', // 10MB max
        ];
    }

    public function messages(): array
    {
        return [
            'stadium_id.required' => 'Выбор стадиона обязателен.',
            'stadium_id.exists' => 'Выбранный стадион не существует.',
            'svg.required' => 'Файл схемы обязателен для загрузки.',
            'svg.file' => 'Загруженный файл должен быть файлом.',
            'svg.mimes' => 'Файл схемы должен быть в формате SVG.',
            'svg.max' => 'Размер файла схемы не должен превышать 10MB.',
        ];
    }
}

