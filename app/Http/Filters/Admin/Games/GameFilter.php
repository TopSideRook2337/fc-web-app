<?php

namespace App\Http\Filters\Admin\Games;

use App\Http\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

class GameFilter extends AbstractFilter
{
    public const TITLE = 'title';
    public const HOME_TEAM_NAME = 'home_team_name';
    public const AWAY_TEAM_NAME = 'away_team_name';
    public const STATUS = 'status';
    public const STADIUM_ID = 'stadium_id';
    public const DATE_FROM = 'date_from';
    public const DATE_TO = 'date_to';
    public const SORT_BY = 'sort_by';
    public const SORT_DIRECTION = 'sort_direction';

    protected function getCallbacks(): array
    {
        return [
            self::TITLE => [$this, 'title'],
            self::HOME_TEAM_NAME => [$this, 'homeTeamName'],
            self::AWAY_TEAM_NAME => [$this, 'awayTeamName'],
            self::STATUS => [$this, 'status'],
            self::STADIUM_ID => [$this, 'stadiumId'],
            self::DATE_FROM => [$this, 'dateFrom'],
            self::DATE_TO => [$this, 'dateTo'],
            self::SORT_BY => [$this, 'sortBy'],
        ];
    }

    public function title(Builder $builder, $value)
    {
        $builder->where('title', 'like', "%{$value}%");
    }

    public function homeTeamName(Builder $builder, $value)
    {
        $builder->where('home_team_name', 'like', "%{$value}%");
    }

    public function awayTeamName(Builder $builder, $value)
    {
        $builder->where('away_team_name', 'like', "%{$value}%");
    }

    public function status(Builder $builder, $value)
    {
        $builder->where('status', $value);
    }

    public function stadiumId(Builder $builder, $value)
    {
        $builder->where('stadium_id', $value);
    }

    public function dateFrom(Builder $builder, $value)
    {
        $builder->where('start_at', '>=', $value);
    }

    public function dateTo(Builder $builder, $value)
    {
        $builder->where('start_at', '<=', $value);
    }

    public function sortBy(Builder $builder, $value)
    {
        $direction = request('sort_direction', 'desc');
        $allowedSorts = ['id', 'title', 'home_team_name', 'away_team_name', 'start_at', 'status', 'stadium_id'];
        
        if (in_array($value, $allowedSorts)) {
            $builder->orderBy($value, $direction);
        }
    }
}
