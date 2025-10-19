<?php

namespace App\Http\Filters\Admin\Posts;

use App\Http\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

class PostFilter extends AbstractFilter
{
    public const STATUS = 'status';
    public const SEARCH = 'search';
    public const DATE_FROM = 'date_from';
    public const DATE_TO = 'date_to';
    public const SORT_BY = 'sort_by';
    public const SORT_DIRECTION = 'sort_direction';

    protected function getCallbacks(): array
    {
        return [
            self::STATUS => [$this, 'status'],
            self::SEARCH => [$this, 'search'],
            self::DATE_FROM => [$this, 'dateFrom'],
            self::DATE_TO => [$this, 'dateTo'],
            self::SORT_BY => [$this, 'sortBy'],
        ];
    }

    public function status(Builder $builder, $value)
    {
        $statuses = is_array($value) ? $value : explode(',', $value);
        $builder->whereIn('status', $statuses);
    }

    public function search(Builder $builder, $value)
    {
        $builder->where(function ($query) use ($value) {
            $query->where('title', 'like', "%{$value}%")
                  ->orWhere('content', 'like', "%{$value}%")
                  ->orWhere('excerpt', 'like', "%{$value}%");
        });
    }

    public function dateFrom(Builder $builder, $value)
    {
        $builder->where('created_at', '>=', $value);
    }

    public function dateTo(Builder $builder, $value)
    {
        $builder->where('created_at', '<=', $value);
    }

    public function sortBy(Builder $builder, $value)
    {
        $direction = request('sort_direction', 'desc');
        $allowedSorts = ['id', 'title', 'status', 'author_name', 'created_at', 'published_at'];
        
        if (in_array($value, $allowedSorts)) {
            $builder->orderBy($value, $direction);
        }
    }
}
