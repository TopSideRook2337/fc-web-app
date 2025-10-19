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
        $matches = Game::with('stadium')
            ->whereIn('status', ['tickets_open', 'ready'])
            ->where('start_at', '>', now())
            ->orderBy('start_at', 'asc')
            ->get([
                'id',
                'title',
                'home_team_name',
                'away_team_name',
                'home_team_logo_path',
                'away_team_logo_path',
                'start_at',
                'status',
                'stadium_id'
            ]);

        return response()->json($matches);
    }
}
