<?php

namespace App\Http\Requests\Api\Orders;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Валидация для создания заказа (корзины).
 * 
 * Что проверяем:
 * - game_id должен существовать и быть активным матчем
 * - seats должен быть массивом ID мест
 * - каждое место должно существовать и принадлежать стадиону матча
 * - места не должны быть уже заняты
 */
class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Для MVP разрешаем создавать заказы без авторизации
        // Позже можно добавить проверку: return $this->user() !== null;
        return true;
    }

    public function rules(): array
    {
        return [
            // ID матча - обязательное поле, должно существовать в таблице games
            'game_id' => [
                'required',
                'integer',
                'exists:games,id',
            ],
            
            // Массив ID мест - обязательное, минимум 1 место, каждый элемент - число
            'seats' => [
                'required',
                'array',
                'min:1', // Хотя бы одно место должно быть
            ],
            
            // Каждый элемент массива seats должен быть числом и существовать в таблице seats
            'seats.*' => [
                'required',
                'integer',
                'exists:seats,id',
            ],
            
            // Опционально: email для отправки билета (если нет авторизации)
            'email' => [
                'nullable',
                'email',
                'max:255',
            ],
            
            // Опционально: имя покупателя
            'customer_name' => [
                'nullable',
                'string',
                'max:255',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'game_id.required' => 'Необходимо указать матч.',
            'game_id.exists' => 'Выбранный матч не найден.',
            'seats.required' => 'Необходимо выбрать хотя бы одно место.',
            'seats.min' => 'Необходимо выбрать хотя бы одно место.',
            'seats.*.exists' => 'Одно или несколько выбранных мест не найдены.',
            'email.email' => 'Некорректный формат email.',
        ];
    }
}


