# 📋 Описание Webhook для платежей

## 🎯 Назначение

Webhook — это эндпоинт, который платёжная система (Stripe, Tinkoff, Sber и т.д.) вызывает автоматически, когда происходит событие с платежом (например, оплата успешна или отклонена).

**Зачем это нужно:**
- Платёжная система уведомляет наш сервер о статусе платежа
- Мы обновляем статус заказа в БД
- Генерируем QR-коды и отправляем билеты на email
- Начисляем бонусные баллы

---

## 🔧 Как это работает (общая схема)

### Шаг 1: Пользователь инициирует оплату
```
Фронтенд → POST /api/orders/{id}/pay
```

### Шаг 2: Наш сервер создаёт сессию оплаты
```
Наш сервер → Stripe/Tinkoff API: "Создай сессию оплаты на сумму X"
Stripe/Tinkoff → Наш сервер: "Вот payment_url и session_id"
Наш сервер → Фронтенд: { payment_url: "https://pay.stripe.com/..." }
```

### Шаг 3: Пользователь оплачивает
```
Пользователь → Переходит на payment_url
Пользователь → Вводит данные карты на сайте платёжной системы
Пользователь → Нажимает "Оплатить"
```

### Шаг 4: Платёжная система обрабатывает платёж
```
Stripe/Tinkoff → Обрабатывает платёж
Stripe/Tinkoff → Отправляет webhook на наш сервер
```

### Шаг 5: Наш сервер получает webhook
```
Stripe/Tinkoff → POST /api/payments/webhook
Наш сервер → Проверяет подпись (безопасность!)
Наш сервер → Обновляет статус заказа на 'paid'
Наш сервер → Генерирует QR-коды
Наш сервер → Отправляет email с билетами
Наш сервер → Начисляет бонусные баллы
```

---

## 📝 Структура эндпоинта

### `POST /api/payments/webhook`

**Особенности:**
- **Без авторизации** (публичный эндпоинт)
- **Без CSRF защиты** (webhook приходит извне)
- **С проверкой подписи** (критично для безопасности!)

---

## 🔒 Безопасность

### 1. Проверка подписи (Signature Verification)

Платёжные системы подписывают каждый webhook специальным секретным ключом.

**Как это работает:**
```php
// Stripe отправляет заголовок: X-Stripe-Signature
// Tinkoff отправляет заголовок: X-Tinkoff-Signature

// Мы проверяем:
$signature = $request->header('X-Stripe-Signature');
$payload = $request->getContent();
$secret = config('services.stripe.webhook_secret');

// Вычисляем ожидаемую подпись
$expectedSignature = hash_hmac('sha256', $payload, $secret);

// Сравниваем
if ($signature !== $expectedSignature) {
    // Подпись не совпадает - это не от Stripe!
    abort(401, 'Invalid signature');
}
```

**Зачем это нужно:**
- Защита от подделки webhook'ов
- Только платёжная система может вызвать наш эндпоинт
- Без проверки подписи злоумышленник может подделать "успешную оплату"

### 2. Идемпотентность (Idempotency)

Один и тот же webhook может прийти несколько раз (из-за сетевых проблем).

**Как обрабатываем:**
```php
// Сохраняем ID события от платёжной системы
$eventId = $request->input('event_id');

// Проверяем, обрабатывали ли мы уже это событие
if (PaymentEvent::where('external_id', $eventId)->exists()) {
    // Уже обработали - просто возвращаем успех
    return response()->json(['status' => 'already_processed'], 200);
}

// Обрабатываем событие
// Сохраняем ID события
PaymentEvent::create(['external_id' => $eventId, ...]);
```

---

## 📦 Структура данных webhook

### Пример от Stripe:
```json
{
  "id": "evt_1234567890",
  "type": "payment_intent.succeeded",
  "data": {
    "object": {
      "id": "pi_1234567890",
      "amount": 500000,  // 5000.00 RUB в копейках
      "currency": "rub",
      "metadata": {
        "order_id": "123"
      },
      "status": "succeeded"
    }
  }
}
```

### Пример от Tinkoff:
```json
{
  "TerminalKey": "1234567890",
  "OrderId": "123",
  "Success": true,
  "Status": "CONFIRMED",
  "Amount": 500000,
  "PaymentId": "1234567890"
}
```

---

## 🛠️ Реализация (когда будем делать)

### 1. Контроллер: `app/Http/Controllers/Api/Payments/WebhookController.php`

```php
class WebhookController extends Controller
{
    public function __invoke(Request $request)
    {
        // 1. Проверяем подпись
        $this->verifySignature($request);
        
        // 2. Проверяем идемпотентность
        $eventId = $request->input('id');
        if ($this->isAlreadyProcessed($eventId)) {
            return response()->json(['status' => 'ok'], 200);
        }
        
        // 3. Определяем тип события
        $eventType = $request->input('type'); // payment_intent.succeeded
        
        // 4. Обрабатываем событие
        if ($eventType === 'payment_intent.succeeded') {
            $this->handlePaymentSuccess($request);
        } elseif ($eventType === 'payment_intent.payment_failed') {
            $this->handlePaymentFailure($request);
        }
        
        // 5. Сохраняем событие
        PaymentEvent::create(['external_id' => $eventId, ...]);
        
        return response()->json(['status' => 'ok'], 200);
    }
    
    private function handlePaymentSuccess(Request $request)
    {
        // Получаем order_id из metadata
        $orderId = $request->input('data.object.metadata.order_id');
        
        // Находим заказ
        $order = Order::findOrFail($orderId);
        
        // Обновляем статус через существующий сервис
        // Он сам сгенерирует QR, отправит email, начислит баллы
        app(AdminOrderService::class)->updateStatus($order, 'paid');
    }
}
```

### 2. Маршрут: `routes/api.php`

```php
// Webhook для платежей - без CSRF и авторизации
Route::post('/payments/webhook', [Payments\WebhookController::class, '__invoke'])
    ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])
    ->name('api.payments.webhook');
```

### 3. Модель для идемпотентности: `app/Models/PaymentEvent.php`

```php
class PaymentEvent extends Model
{
    protected $fillable = [
        'external_id',      // ID события от платёжной системы
        'event_type',       // Тип события (payment_intent.succeeded)
        'order_id',         // ID заказа
        'processed_at',     // Когда обработали
    ];
}
```

### 4. Миграция:

```php
Schema::create('payment_events', function (Blueprint $table) {
    $table->id();
    $table->string('external_id')->unique(); // ID от Stripe/Tinkoff
    $table->string('event_type');
    $table->foreignId('order_id')->nullable()->constrained();
    $table->json('payload'); // Полные данные события
    $table->timestamp('processed_at');
    $table->timestamps();
});
```

---

## 🧪 Тестирование

### Локально (через ngrok):

1. Устанавливаем ngrok: `ngrok http 8000`
2. Получаем публичный URL: `https://abc123.ngrok.io`
3. Настраиваем в Stripe Dashboard:
   - Webhook URL: `https://abc123.ngrok.io/api/payments/webhook`
   - События: `payment_intent.succeeded`, `payment_intent.payment_failed`
4. Тестируем через Stripe CLI или создаём тестовый платёж

### В продакшене:

1. Настраиваем webhook в панели платёжной системы
2. Указываем URL: `https://yourdomain.com/api/payments/webhook`
3. Тестируем с тестовыми картами

---

## ⚠️ Важные моменты

1. **Всегда проверяй подпись** — без этого webhook небезопасен
2. **Обрабатывай идемпотентность** — один платёж может прийти несколько раз
3. **Логируй все события** — для отладки и аудита
4. **Обрабатывай ошибки** — если что-то пошло не так, верни 500, чтобы платёжная система повторила запрос
5. **Тестируй на sandbox** — перед продакшеном обязательно протестируй на тестовом окружении

---

## 📚 Полезные ссылки

- [Stripe Webhooks Guide](https://stripe.com/docs/webhooks)
- [Tinkoff API Documentation](https://www.tinkoff.ru/kassa/develop/api/)
- [Laravel Webhook Handling](https://laravel.com/docs/queues#handling-failed-jobs)


