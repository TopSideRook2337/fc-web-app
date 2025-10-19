<?php

namespace App\Http\Controllers\Admin\Games;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    public function __invoke(Game $game)
    {
        $game->load('stadium');
        
        return view('admin.games.show', compact('game'));
    }
}
