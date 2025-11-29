<?php

namespace App\Http\Filters\Admin\LoyaltyPoints;

use App\Http\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

class LoyaltyPointFilter extends AbstractFilter
{
    public const USER_ID = 'user_id';
    public const ORDER_ID = 'order_id';
    public const DATE_FROM = 'date_from';
    public const DATE_TO = 'date_to';
    public const SORT_BY = 'sort_by';
    public const SORT_DIRECTION = 'sort_direction';

    protected function getCallbacks(): array
    {
        return [
            self::USER_ID => [$this, 'userId'],
            self::ORDER_ID => [$this, 'orderId'],
            self::DATE_FROM => [$this, 'dateFrom'],
            self::DATE_TO => [$this, 'dateTo'],
            self::SORT_BY => [$this, 'sortBy'],
        ];
    }

    public function userId(Builder $builder, $value)
    {
        $builder->where('user_id', $value);
    }

    public function orderId(Builder $builder, $value)
    {
        $builder->where('related_order_id', $value);
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
        $allowedSorts = ['id', 'user_id', 'points', 'created_at'];
        
        if (in_array($value, $allowedSorts)) {
            $builder->orderBy($value, $direction);
        }
    }
}







