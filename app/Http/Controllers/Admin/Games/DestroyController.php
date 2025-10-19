<?php

namespace App\Http\Controllers\Admin\Games;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;

class DestroyController extends Controller
{
    public function __invoke(Game $game)
    {
        $gameTitle = $game->title;
        $game->delete();
        
        return redirect()
            ->route('admin.games.index')
            ->with('success', "Матч '{$gameTitle}' успешно удален!");
    }
}
