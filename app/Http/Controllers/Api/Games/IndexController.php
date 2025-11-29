<?php

namespace App\Http\Controllers\Api\Games;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Post;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $query = Game::query()->with('stadium');

        // Фильтры
        if ($request->filled('status')) {
            $query->whereIn('status', (array) $request->input('status'));
        } else {
            $query->whereIn('status', ['tickets_open', 'ready']);
        }

        if ($request->filled('date_from')) {
            $query->where('start_at', '>=', $request->date('date_from'));
        } else {
            $query->where('start_at', '>', now());
        }

        if ($request->filled('date_to')) {
            $query->where('start_at', '<=', $request->date('date_to'));
        }

        if ($request->filled('stadium_id')) {
            $query->where('stadium_id', $request->integer('stadium_id'));
        }

        $query->orderBy('start_at', 'asc');

        // Пагинация
        $perPage = min(max((int) $request->input('per_page', 20), 1), 100);
        $page = max((int) $request->input('page', 1), 1);

        $paginator = $query->select([
            'id',
            'title',
            'home_team_name',
            'away_team_name',
            'home_team_logo_path',
            'away_team_logo_path',
            'start_at',
            'status',
            'stadium_id'
        ])->paginate($perPage, ['*'], 'page', $page);

        $data = $paginator->getCollection()->map(function ($game) {
            return [
                'id' => $game->id,
                'title' => $game->title,
                'home_team_name' => $game->home_team_name,
                'away_team_name' => $game->away_team_name,
                'home_team_logo_path' => $game->home_team_logo_path,
                'away_team_logo_path' => $game->away_team_logo_path,
                'start_at' => optional($game->start_at)->toIso8601String(),
                'status' => $game->status,
                'stadium' => $game->stadium ? [
                    'id' => $game->stadium->id,
                    'name' => $game->stadium->name,
                ] : null,
            ];
        })->values();

        return response()->json([
            'data' => $data,
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
                'last_page' => $paginator->lastPage(),
            ],
        ]);
    }
}
