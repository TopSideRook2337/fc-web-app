# 📋 Техническое задание: Футбольный клуб

> **Цель проекта:** Создать информационный сайт футбольного клуба с продажей билетов через админ-панель.  
> **Стек:** Laravel 10 (бэкенд + админка), Next.js 14 (клиентская часть)

---

## 🧩 Основные модули проекта

1. **Бэкенд (Laravel)** — API, модели, логика
2. **Админ-панель** — управление контентом и продажами
3. **Клиентская часть (Next.js)** — сайт для болельщиков
4. **API** — единая точка интеграции между фронтендом и бэкендом

---

## ✅ Этап 1: Подготовка и окружение

| Задача | Статус |
|-------|---|
| Установить Laravel 10 | ✅ |
| Настроить `.env`, подключение к БД (MySQL) | ✅ |
| Настроить `php artisan serve` и проверить доступность | ✅ |
| Установить Laravel Sanctum (для API-аутентификации) | ✅ |
| Настроить CORS (`laravel-cors`) | ✅ |
| Инициализировать Git-репозиторий | ✅ |
| Создать ветку `dev` и `main` | ✅ |

---

## ✅ Этап 2: Модели и миграции (База данных)

| Задача                                    | Статус |
|-------------------------------------------|--|
| Создать миграцию: `users` (с полем `role`) | ✅ |
| Создать миграцию: `posts` (новости)       | ✅ |
| Создать миграцию: `stadiums`              | ✅ |
| Создать миграцию: `sectors`               | ✅ |
| Создать миграцию: `seats`                 | ✅ |
| Создать миграцию: `games` (матчи)         | ✅ |
| Создать миграцию: `orders`                | ✅ |
| Создать миграцию: `order_items`           | ✅ |
| Создать миграцию: `tickets` (билеты)      | ✅ |
| Создать миграцию: `loyalty_points`        | ✅ |
| Создать миграцию: `notifications`         | ✅ |
| Создать миграцию: `settings`              | ✅ |
| Выполнить `php artisan migrate`           | ✅ |
| Проверить связи между моделями (Eloquent) | ✅ |

---

## ✅ Этап 3: API (RESTful)

| Задача | Статус |
|-------|------|
| Создать контроллеры API: `Api\PostController` | ✅ |
| Создать контроллеры API: `Api\MatchController` | ✅ |
| Создать контроллеры API: `Api\SeatController` | ✅ |
| Создать контроллеры API: `Api\OrderController` | ✅ |
| Реализовать маршруты `/api/posts`, `/api/matches`, `/api/seats/{match}` | ✅ |
| Добавить пагинацию и фильтрацию (по дате, статусу) | ✅ |
| Настроить Sanctum: защита роутов, создание токена для админа | ✅ |
| Протестировать API через Postman / Thunder Client | ✅ |

---

## ✅ Этап 4: Админ-панель (AdminLTE)

| Задача | Статус |
|-------|---|
| Установить AdminLTE: `composer require jeroennoten/laravel-adminlte` | ✅ |
| Запустить установку: `php artisan adminlte:install` | ✅ |
| Настроить конфигурацию AdminLTE (цвета, логотип) | ✅ |
| Создать middleware для админ-панели | ✅ |
| Создать базовый layout для админки | ✅ |
| Настроить маршруты админ-панели (`/admin/*`) | ✅ |
| Создать Dashboard контроллер и страницу (статистика) | ✅ |
| **Posts (Новости) - ЗАВЕРШЕНО:** | |
| Создать контроллеры: `Admin\Posts\IndexController, CreateController, StoreController, ShowController, EditController, UpdateController, DestroyController` | ✅ |
| Создать сервисы: `Admin\Services\PostService` (store, update) | ✅ |
| Создать реквесты: `Admin\Requests\Posts\StoreRequest, UpdateRequest` | ✅ |
| Создать фильтр: `Admin\Filters\Posts\PostFilter` | ✅ |
| Создать шаблоны: `admin.posts.index, show, create, edit` | ✅ |
| Реализовать серверную фильтрацию и сортировку | ✅ |
| Добавить пагинацию Bootstrap | ✅ |
| **Games (Матчи):** | |
| Создать контроллеры: `Admin\Games\IndexController, CreateController, StoreController, ShowController, EditController, UpdateController, DestroyController` | ✅ |
| Создать сервисы: `Admin\Services\GameService` (store, update) | ✅ |
| Создать реквесты: `Admin\Requests\Games\StoreRequest, UpdateRequest` | ✅ |
| Создать фильтр: `Admin\Filters\Games\GameFilter` | ✅ |
| Создать шаблоны: `admin.games.index, show, create, edit` | ✅ |
| **Stadiums (Стадионы) - Интерактивные схемы:** | |
| Создать контроллеры: `Admin\Stadiums\IndexController, CreateController, StoreController, ShowController, EditController, UpdateController, DestroyController` | ☐ |
| Создать сервисы: `Admin\Services\StadiumService` (store, update) | ☐ |
| Создать реквесты: `Admin\Requests\Stadiums\StoreRequest, UpdateRequest` | ☐ |
| Создать фильтр: `Admin\Filters\Stadiums\StadiumFilter` | ☐ |
| Создать шаблоны: `admin.stadiums.index, show, create, edit` | ☐ |
| **Stadium Schemes (Схемы стадиона) - НОВЫЙ модуль:** | |
| Создать контроллеры: `Admin\StadiumSchemes\IndexController, UploadController, EditController, PreviewController` | ☐ |
| Создать сервисы: `Admin\Services\StadiumSchemeService` (upload, parse SVG) | ☐ |
| Создать реквесты: `Admin\Requests\StadiumSchemes\UploadRequest, EditRequest` | ☐ |
| Создать шаблоны: `admin.stadium-schemes.index, upload, edit, preview` | ☐ |
| **Seat Management (Управление местами) - НОВЫЙ модуль:** | |
| Создать контроллеры: `Admin\SeatManagement\IndexController, BulkUpdateController, BlockController, GenerateController` | ☐ |
| Создать сервисы: `Admin\Services\SeatManagementService` (bulk operations) | ☐ |
| Создать реквесты: `Admin\Requests\SeatManagement\BulkUpdateRequest, BlockRequest` | ☐ |
| Создать шаблоны: `admin.seat-management.index, bulk-update, block` | ☐ |
| **Orders (Заказы):** | |
| Создать контроллеры: `Admin\Orders\IndexController, ShowController, EditController, UpdateController` | ☐ |
| Создать сервисы: `Admin\Services\OrderService` (update) | ☐ |
| Создать реквесты: `Admin\Requests\Orders\UpdateRequest` | ☐ |
| Создать фильтр: `Admin\Filters\Orders\OrderFilter` | ☐ |
| Создать шаблоны: `admin.orders.index, show, edit` | ☐ |
| **Tickets (Билеты):** | |
| Создать контроллеры: `Admin\Tickets\IndexController, ShowController` | ☐ |
| Создать фильтр: `Admin\Filters\Tickets\TicketFilter` | ☐ |
| Создать шаблоны: `admin.tickets.index, show` | ☐ |
| **Users (Пользователи):** | |
| Создать контроллеры: `Admin\Users\IndexController, CreateController, StoreController, ShowController, EditController, UpdateController, DestroyController` | ☐ |
| Создать сервисы: `Admin\Services\UserService` (store, update) | ☐ |
| Создать реквесты: `Admin\Requests\Users\StoreRequest, UpdateRequest` | ☐ |
| Создать фильтр: `Admin\Filters\Users\UserFilter` | ☐ |
| Создать шаблоны: `admin.users.index, show, create, edit` | ☐ |
| **LoyaltyPoints (Бонусы):** | |
| Создать контроллеры: `Admin\LoyaltyPoints\IndexController, ShowController` | ☐ |
| Создать фильтр: `Admin\Filters\LoyaltyPoints\LoyaltyPointFilter` | ☐ |
| Создать шаблоны: `admin.loyaltypoints.index, show` | ☐ |
| **Общие компоненты:** | |
| Создать базовый layout: `admin.layouts.app` | ✅ |
| Создать includes: `admin.includes.header, sidebar, footer` | ✅ |
| Создать компоненты: `admin.components.table, form, modal` | ☐ |
| Настроить навигационное меню админки | ✅ |
| Добавить валидацию форм в админке | ✅ |
| Настроить права доступа (роли: admin, manager) | ☐ |
| **Дополнительные поля БД для схем:** | |
| Добавить `sector_coordinates` в таблицу `stadiums` | ✅ |
| Добавить `scheme_svg_path` и `coordinates` в таблицу `sectors` | ✅ |
| Обновить модели с новыми полями | ✅ |

---

### 🔹 Приложение C: Выбор админ-панели

**Выбрано: AdminLTE**
- ✅ Бесплатный и открытый исходный код
- ✅ Основан на Bootstrap 4 (знакомый стек)
- ✅ Много готовых компонентов (таблицы, формы, виджеты)
- ✅ Легко кастомизируется под нужды проекта
- ✅ Хорошая интеграция с Laravel через пакет `jeroennoten/laravel-adminlte`
- ✅ Подходит для традиционного подхода (отдельные контроллеры и шаблоны)

**Альтернативы (не выбраны):**
- **Filament:** Слишком "магический", мало контроля над кодом
- **Laravel Nova:** Платный ($99/проект), меньше гибкости
- **Backpack:** Платный для коммерческого использования
- **CoreUI:** Меньше готовых компонентов
- **Argon Dashboard:** Меньше функциональности

### 🔹 Приложение D: Структура файлов по конвенции Laravel

**Для каждой сущности (например, Post):**

**Контроллеры (Single Action):**
```
app/Http/Controllers/Admin/Posts/
├── IndexController.php     - список записей
├── CreateController.php    - форма создания
├── StoreController.php     - сохранение новой записи
├── ShowController.php      - просмотр записи
├── EditController.php       - форма редактирования
├── UpdateController.php     - обновление записи
└── DestroyController.php    - удаление записи
```

**Сервисы:**
```
app/Services/Admin/PostService.php
├── store(array $data)   - логика создания
└── update(Post $post, array $data) - логика обновления
```

**Реквесты:**
```
app/Http/Requests/Admin/Posts/
├── StoreRequest.php    - валидация для создания
└── UpdateRequest.php   - валидация для обновления
```

**Фильтры:**
```
app/Http/Filters/Admin/PostFilter.php
├── status()   - фильтр по статусу
├── date()     - фильтр по дате
└── search()   - поиск по тексту
```

**Шаблоны:**
```
resources/views/admin/posts/
├── index.blade.php   - список записей
├── show.blade.php    - просмотр записи
├── create.blade.php  - форма создания
└── edit.blade.php    - форма редактирования
```

**Общие компоненты:**
```
resources/views/admin/
├── layouts/app.blade.php           - основной layout
├── includes/header.blade.php       - шапка
├── includes/sidebar.blade.php      - боковое меню
├── includes/footer.blade.php       - подвал
└── components/
    ├── table.blade.php             - таблица
    ├── form.blade.php              - форма
    └── modal.blade.php             - модальные окна
```

---

## ✅ Этап 5: Логика бизнес-процессов

| Задача | Статус |
|-------|--------|
| Реализовать создание мест автоматически по сектору (ряды x номера) | ☐ |
| Реализовать уникальность места на матч (индекс `(seat_id, match_id)` в `tickets`) | ☐ |
| Добавить статусы заказа: cart, pending, paid, cancelled, expired | ☐ |
| Реализовать временное бронирование места (резерв на 15 мин) | ☐ |
| Настроить Job: `ReleaseExpiredReservations` (очередь + schedule) | ☐ |
| Генерация QR-кода при оплате билета | ☐ |
| Сохранение QR в storage, привязка к `ticket` | ☐ |
| Отправка email с билетом после оплаты (Mailable) | ☐ |
| Реализовать начисление бонусных баллов за покупку | ☐ |

---

## ✅ Этап 6: Платежи

| Задача | Статус |
|-------|--------|
| Выбрать платёжную систему: Stripe / Tinkoff / Sber | ☐ |
| Установить SDK (например, `stripe/stripe-php`) | ☐ |
| Создать маршрут `/api/payment/create-session` | ☐ |
| Реализовать Webhook для подтверждения оплаты | ☐ |
| Обработка статуса `paid` в заказе и билете | ☐ |
| Режим тестирования (sandbox) | ☐ |

---

## ✅ Этап 7: Клиентская часть (Next.js)

| Задача | Статус |
|-------|--------|
| Создать проект: `create-next-app` | ☐ |
| Настроить Tailwind CSS | ☐ |
| Создать страницы: Главная, Новости, Матчи, Билеты, Профиль | ☐ |
| Подключиться к Laravel API (через fetch или axios) | ☐ |
| Реализовать вывод списка новостей | ☐ |
| Реализовать страницу матча с кнопкой "Купить билеты" | ☐ |
| Схема стадиона: SVG с кликабельными местами (по секторам) | ☐ |
| Корзина: выбор мест → оформление заказа | ☐ |
| Авторизация: вход через Laravel Sanctum (токен) | ☐ |
| Профиль пользователя: история заказов, баллы | ☐ |
| Адаптивность (mobile-first) | ☐ |

---

## ✅ Этап 8: Безопасность и производительность

| Задача | Статус |
|-------|--------|
| Валидация всех форм (на бэкенде и фронтенде) | ☐ |
| Защита от XSS, CSRF | ☐ |
| Ограничение запросов (Rate limiting) | ☐ |
| Кэширование часто запрашиваемых данных (матчи, сектора) | ☐ |
| Очереди (Redis + Horizon) для email, бронирования | ☐ |
| Логирование ошибок (Sentry или Monolog) | ☐ |

---

## ✅ Этап 9: Тестирование

| Задача | Статус |
|-------|--------|
| Написать Unit-тесты: модель `Ticket`, `Order` | ☐ |
| Написать Feature-тесты: API `/api/matches` | ☐ |
| Ручное тестирование: сценарии покупки билета | ☐ |
| Проверка админ-панели: все CRUD работают | ☐ |
| Тестирование на мобильных устройствах | ☐ |

---

## ✅ Этап 10: Деплой и поддержка

| Задача | Статус |
|-------|--------|
| Выбрать хостинг: Laravel — Forge/VPS, Next.js — Vercel | ☐ |
| Настроить домен и SSL (Let’s Encrypt) | ☐ |
| Залить код на сервер (CI/CD или вручную) | ☐ |
| Настроить резервное копирование БД | ☐ |
| Документация: краткая инструкция по обновлению | ☐ |
| План доработок (мерч, расписания тренировок, чат болельщиков) | ☐ |

---

## 📎 Приложения

### 🔹 Приложение A: Статусы

- **Матч:** `draft`, `ready`, `tickets_open`, `completed`, `cancelled`
- **Заказ:** `cart`, `pending`, `paid`, `cancelled`, `expired`
- **Билет:** `reserved`, `paid`, `used`, `cancelled`
- **Пользователь:** `active`, `blocked`

### 🔹 Приложение B: Права доступа

- **Админ:** полный доступ
- **Контент-менеджер:** посты, матчи (без билетов)
- **Менеджер продаж:** заказы, билеты (без новостей)

> *Реализуется позже через Spatie Laravel Permission.*

---

💡 **Как использовать:**
1. Сохрани файл как `PROJECT-TODO.md` в корне проекта.
2. Отмечай `[x]` выполненные задачи.
3. Обновляй при необходимости.

---

## Нужно реализовать в срочном порядке

1) API: Игры (Games)
- Добавить `GET /api/games/{id}` — детальная карточка матча (стадион, статус, время, опционально категории/цены).
- Доработать `GET /api/games` — фильтры (`status`, `date_from`, `date_to`, `stadium_id`), пагинация (`page`, `per_page`), единый формат ответа (`data`, `meta`).

2) API: Секторы и места
- `GET /api/games/{id}/sectors` — список секторов матча с базовыми данными и доступностью.
- `GET /api/games/{id}/sectors/{sectorId}/seats` — места сектора (координаты, доступность, фильтр `onlyAvailable`).
- Пересмотреть текущий `GET /api/seats/{match}`: добавить `onlyAvailable`, `groupBy=sector`, учитывать `reservation_expires_at`.

3) API: Корзина/Заказы
- Реализовать `POST /api/orders` — создание корзины/резерва с транзакциями, проверками и `reservation_expires_at`.
- `GET /api/orders/{id}` — детальный заказ с таймерами резерва, билетами, суммой.
- `POST /api/orders/{id}/cancel` — отмена из `cart|pending`.
- `POST /api/orders/{id}/pay` и `POST /api/payments/webhook` — интеграция платежей (dev: мок).

4) Аутентификация для SPA
- Настроить Sanctum-поток (cookie) или токены; эндпоинты `auth/login`, `auth/register`, `auth/logout`, `auth/me` (если SPA).

5) Почта/QR/Бонусы
- Возвращать в API ссылки на QR для оплаченных билетов (защищённо).
- Эндпоинты истории бонусов и расчёт применения к заказу (опционально).
