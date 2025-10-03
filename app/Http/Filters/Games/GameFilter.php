<?php

namespace App\Http\Filters\Games;

use App\Http\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

class GameFilter extends AbstractFilter
{
    public const STATUS = 'status';
    public const FROM = 'from';
    public const TO = 'to';

    protected function getCallbacks(): array
    {
        return [
            self::STATUS => [$this, 'status'],
            self::FROM   => [$this, 'from'],
            self::TO     => [$this, 'to'],
        ];
    }

    public function status(Builder $builder, $value)
    {
        $statuses = is_array($value) ? $value : explode(',', $value);
        $builder->whereIn('status', $statuses);
    }

    public function from(Builder $builder, $value)
    {
        $builder->where('start_at', '>=', $value);
    }

    public function to(Builder $builder, $value)
    {
        $builder->where('start_at', '<=', $value);
    }

    protected function before(Builder $builder)
    {
        // Только будущие матчи
        $builder->where('start_at', '>', now());

        // По умолчанию — только открытые продажи
        if (!$this->getQueryParam('status')) {
            $builder->whereIn('status', ['tickets_open', 'ready']);
        }
    }
}
