<?php

namespace App\Http\Filters\Admin\Stadiums;

use App\Http\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

class StadiumFilter extends AbstractFilter
{
    public const NAME = 'name';
    public const CAPACITY_MIN = 'capacity_min';
    public const CAPACITY_MAX = 'capacity_max';
    public const SORT_BY = 'sort_by';
    public const SORT_DIRECTION = 'sort_direction';

    protected function getCallbacks(): array
    {
        return [
            self::NAME => [$this, 'name'],
            self::CAPACITY_MIN => [$this, 'capacityMin'],
            self::CAPACITY_MAX => [$this, 'capacityMax'],
            self::SORT_BY => [$this, 'sortBy'],
        ];
    }

    public function name(Builder $builder, $value)
    {
        $builder->where('name', 'like', "%{$value}%");
    }

    public function capacityMin(Builder $builder, $value)
    {
        $builder->where('capacity', '>=', $value);
    }

    public function capacityMax(Builder $builder, $value)
    {
        $builder->where('capacity', '<=', $value);
    }

    public function sortBy(Builder $builder, $value)
    {
        $direction = request('sort_direction', 'desc');
        $allowedSorts = ['id', 'name', 'capacity', 'created_at'];
        
        if (in_array($value, $allowedSorts)) {
            $builder->orderBy($value, $direction);
        }
    }
}
