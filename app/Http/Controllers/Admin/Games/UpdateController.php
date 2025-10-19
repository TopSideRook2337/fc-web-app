<?php

namespace App\Http\Controllers\Admin\Games;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Games\UpdateRequest;
use App\Models\Game;
use App\Services\Admin\GameService;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    public function __invoke(UpdateRequest $request, Game $game, GameService $gameService)
    {
        $game = $gameService->update($game, $request->validated());
        
        return redirect()
            ->route('admin.games.show', $game)
            ->with('success', 'Матч успешно обновлен!');
    }
}
