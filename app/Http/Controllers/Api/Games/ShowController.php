<?php

namespace App\Http\Controllers\Api\Games;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    public function __invoke(Request $request, int $id)
    {
        $game = Game::with(['stadium'])
            ->select([
                'id',
                'title',
                'home_team_name',
                'away_team_name',
                'home_team_logo_path',
                'away_team_logo_path',
                'start_at',
                'status',
                'stadium_id',
            ])
            ->findOrFail($id);

        return response()->json([
            'data' => [
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
                    'address' => $game->stadium->address,
                ] : null,
            ],
        ]);
    }
}




