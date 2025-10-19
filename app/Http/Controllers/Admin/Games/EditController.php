<?php

namespace App\Http\Controllers\Admin\Games;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Stadium;
use Illuminate\Http\Request;

class EditController extends Controller
{
    public function __invoke(Game $game)
    {
        $stadiums = Stadium::where('is_active', true)->get();
        
        return view('admin.games.edit', compact('game', 'stadiums'));
    }
}
