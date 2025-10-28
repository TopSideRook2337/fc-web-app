<?php

namespace App\Http\Filters\Admin\Tickets;

use App\Http\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

class TicketFilter extends AbstractFilter
{
    public const STATUS = 'status';
    public const USER_ID = 'user_id';
    public const SECTOR_ID = 'sector_id';
    public const SORT_BY = 'sort_by';

    protected function getCallbacks(): array
    {
        return [
            self::STATUS => [$this, 'status'],
            self::USER_ID => [$this, 'userId'],
            self::SECTOR_ID => [$this, 'sectorId'],
            self::SORT_BY => [$this, 'sortBy'],
        ];
    }

    public function status(Builder $builder, $value)
    {
        $statuses = is_array($value) ? $value : [$value];
        $builder->whereIn('status', $statuses);
    }

    public function userId(Builder $builder, $value)
    {
        $builder->whereHas('order', function ($query) use ($value) {
            $query->where('user_id', $value);
        });
    }

    public function sectorId(Builder $builder, $value)
    {
        $builder->whereHas('seat.sector', function ($query) use ($value) {
            $query->where('id', $value);
        });
    }

    public function sortBy(Builder $builder, $value)
    {
        $direction = request('sort_direction', 'desc');
        $allowedSorts = ['id', 'status', 'created_at', 'reservation_expires_at'];
        
        if (in_array($value, $allowedSorts)) {
            $builder->orderBy($value, $direction);
        }
    }
}

