<?php

namespace App\Http\Controllers\Admin\Games;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Games\StoreRequest;
use App\Models\Game;
use App\Services\Admin\GameService;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request, GameService $gameService)
    {
        $game = $gameService->store($request->validated());
        
        return redirect()
            ->route('admin.games.show', $game)
            ->with('success', 'Матч успешно создан!');
    }
}
