<?php

namespace App\Http\Requests\Admin\Games;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->role === 'admin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'home_team_name' => 'required|string|max:100',
            'away_team_name' => 'required|string|max:100',
            'home_team_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'away_team_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'start_at' => 'required|date|after:now',
            'status' => 'nullable|string|in:draft,ready,tickets_open,completed,cancelled',
            'stadium_id' => 'required|exists:stadiums,id',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Название матча обязательно',
            'title.max' => 'Название матча не должно превышать 255 символов',
            'home_team_name.required' => 'Название домашней команды обязательно',
            'home_team_name.max' => 'Название команды не должно превышать 100 символов',
            'away_team_name.required' => 'Название гостевой команды обязательно',
            'away_team_name.max' => 'Название команды не должно превышать 100 символов',
            'home_team_logo.image' => 'Логотип домашней команды должен быть изображением',
            'home_team_logo.mimes' => 'Логотип должен быть в формате: jpeg, png, jpg, gif, svg',
            'home_team_logo.max' => 'Размер логотипа не должен превышать 2MB',
            'away_team_logo.image' => 'Логотип гостевой команды должен быть изображением',
            'away_team_logo.mimes' => 'Логотип должен быть в формате: jpeg, png, jpg, gif, svg',
            'away_team_logo.max' => 'Размер логотипа не должен превышать 2MB',
            'start_at.required' => 'Дата начала матча обязательна',
            'start_at.date' => 'Неверный формат даты',
            'start_at.after' => 'Дата начала матча должна быть в будущем',
            'status.in' => 'Статус должен быть: draft, ready, tickets_open, completed, cancelled',
            'stadium_id.required' => 'Выбор стадиона обязателен',
            'stadium_id.exists' => 'Выбранный стадион не существует',
        ];
    }
}
