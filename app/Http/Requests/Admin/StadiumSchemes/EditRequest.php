<?php

namespace App\Http\Requests\Admin\StadiumSchemes;

use Illuminate\Foundation\Http\FormRequest;

class EditRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'sector_coordinates' => 'required|array',
            'sector_coordinates.*' => 'array',
            'sector_coordinates.*.x' => 'required|numeric',
            'sector_coordinates.*.y' => 'required|numeric',
        ];
    }

    public function messages(): array
    {
        return [
            'sector_coordinates.required' => 'Координаты секторов обязательны.',
            'sector_coordinates.array' => 'Координаты секторов должны быть массивом.',
            'sector_coordinates.*.array' => 'Каждый сектор должен содержать массив координат.',
            'sector_coordinates.*.x.required' => 'X-координата сектора обязательна.',
            'sector_coordinates.*.x.numeric' => 'X-координата сектора должна быть числом.',
            'sector_coordinates.*.y.required' => 'Y-координата сектора обязательна.',
            'sector_coordinates.*.y.numeric' => 'Y-координата сектора должна быть числом.',
        ];
    }
}

