<?php

namespace App\Http\Filters\Admin\Users;

use App\Http\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

class UserFilter extends AbstractFilter
{
    public const EMAIL = 'email';
    public const ROLE = 'role';
    public const SEARCH = 'search';
    public const SORT_BY = 'sort_by';
    public const SORT_DIRECTION = 'sort_direction';

    protected function getCallbacks(): array
    {
        return [
            self::EMAIL => [$this, 'email'],
            self::ROLE => [$this, 'role'],
            self::SEARCH => [$this, 'search'],
            self::SORT_BY => [$this, 'sortBy'],
        ];
    }

    public function email(Builder $builder, $value)
    {
        $builder->where('email', 'like', "%{$value}%");
    }

    public function role(Builder $builder, $value)
    {
        $roles = is_array($value) ? $value : [$value];
        $builder->whereIn('role', $roles);
    }

    public function search(Builder $builder, $value)
    {
        $builder->where(function ($query) use ($value) {
            $query->where('name', 'like', "%{$value}%")
                  ->orWhere('email', 'like', "%{$value}%");
        });
    }

    public function sortBy(Builder $builder, $value)
    {
        $direction = request('sort_direction', 'desc');
        $allowedSorts = ['id', 'name', 'email', 'role', 'created_at'];
        
        if (in_array($value, $allowedSorts)) {
            $builder->orderBy($value, $direction);
        }
    }
}







