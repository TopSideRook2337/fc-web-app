<?php

namespace App\Http\Requests\Admin\Stadiums;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'total_capacity' => 'required|numeric|min:1',
            'sector_coordinates' => 'nullable|json',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Название стадиона обязательно для заполнения.',
            'name.string' => 'Название стадиона должно быть строкой.',
            'name.max' => 'Название стадиона не должно превышать 255 символов.',
            'address.required' => 'Адрес стадиона обязателен для заполнения.',
            'address.string' => 'Адрес стадиона должен быть строкой.',
            'total_capacity.required' => 'Вместимость стадиона обязательна для заполнения.',
            'total_capacity.numeric' => 'Вместимость стадиона должна быть числом.',
            'total_capacity.min' => 'Вместимость стадиона должна быть больше 0.',
            'sector_coordinates.json' => 'Координаты секторов должны быть в формате JSON.',
        ];
    }
}
