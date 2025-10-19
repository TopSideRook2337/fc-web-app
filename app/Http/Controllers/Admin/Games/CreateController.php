<?php

namespace App\Http\Controllers\Admin\Games;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Stadium;
use Illuminate\Http\Request;

class CreateController extends Controller
{
    public function __invoke(Request $request)
    {
        $game = new Game();
        $stadiums = Stadium::where('is_active', true)->get();

        return view('admin.games.create', compact('game', 'stadiums'));
    }
}
