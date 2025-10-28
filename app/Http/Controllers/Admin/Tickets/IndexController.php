<?php

namespace App\Http\Controllers\Admin\Tickets;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $perPage = in_array($perPage, [15, 25, 50, 100]) ? $perPage : 15;
        
        $games = Game::with('stadium')
            ->orderBy('start_at', 'desc')
            ->paginate($perPage)
            ->appends($request->query());

        return view('admin.tickets.index', compact('games'));
    }
}

