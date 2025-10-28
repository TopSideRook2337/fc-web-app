<?php

namespace App\Http\Filters\Admin\Orders;

use App\Http\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

class OrderFilter extends AbstractFilter
{
    public const USER_ID = 'user_id';
    public const GAME_ID = 'game_id';
    public const STATUS = 'status';
    public const DATE_FROM = 'date_from';
    public const DATE_TO = 'date_to';
    public const SORT_BY = 'sort_by';

    protected function getCallbacks(): array
    {
        return [
            self::USER_ID => [$this, 'userId'],
            self::GAME_ID => [$this, 'gameId'],
            self::STATUS => [$this, 'status'],
            self::DATE_FROM => [$this, 'dateFrom'],
            self::DATE_TO => [$this, 'dateTo'],
            self::SORT_BY => [$this, 'sortBy'],
        ];
    }

    public function userId(Builder $builder, $value)
    {
        $builder->where('user_id', $value);
    }

    public function gameId(Builder $builder, $value)
    {
        $builder->whereHas('tickets', function ($query) use ($value) {
            $query->where('game_id', $value);
        });
    }

    public function status(Builder $builder, $value)
    {
        $statuses = is_array($value) ? $value : [$value];
        $builder->whereIn('status', $statuses);
    }

    public function dateFrom(Builder $builder, $value)
    {
        $builder->where('created_at', '>=', $value);
    }

    public function dateTo(Builder $builder, $value)
    {
        $builder->where('created_at', '<=', $value . ' 23:59:59');
    }

    public function sortBy(Builder $builder, $value)
    {
        $direction = request('sort_direction', 'desc');
        $allowedSorts = ['id', 'total_amount', 'status', 'created_at', 'paid_at'];
        
        if (in_array($value, $allowedSorts)) {
            $builder->orderBy($value, $direction);
        }
    }
}

