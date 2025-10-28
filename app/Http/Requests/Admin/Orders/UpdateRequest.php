<?php

namespace App\Http\Requests\Admin\Orders;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $order = $this->route('order');
        
        return [
            'status' => [
                'required',
                'string',
                Rule::in(['cart', 'pending', 'paid', 'cancelled', 'expired']),
                function ($attribute, $value, $fail) use ($order) {
                    // Защита: нельзя изменить paid обратно на cart или pending
                    if ($order->status === 'paid' && in_array($value, ['cart', 'pending'])) {
                        $fail('Нельзя изменить статус оплаченного заказа обратно на "' . 
                              ($value === 'cart' ? 'Корзина' : 'Ожидает оплаты') . '".');
                    }
                    
                    // Защита: если заказ был оплачен (есть paid_at), нельзя откатить в cart/pending через cancelled
                    if ($order->paid_at && in_array($value, ['cart', 'pending'])) {
                        $fail('Этот заказ был оплачен ранее (дата оплаты: ' . $order->paid_at->format('d.m.Y H:i') . '). ' .
                              'Нельзя вернуть его в статус "' . 
                              ($value === 'cart' ? 'Корзина' : 'Ожидает оплаты') . '". ' .
                              'Доступны только статусы: Отменен, Истёк.');
                    }
                },
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => 'Статус заказа обязателен для заполнения.',
            'status.string' => 'Статус заказа должен быть строкой.',
            'status.in' => 'Выбранный статус недопустим.',
        ];
    }
}

