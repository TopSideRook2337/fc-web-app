<?php

namespace App\Http\Controllers\Admin\Games;

use App\Http\Controllers\Controller;
use App\Http\Filters\Admin\Games\GameFilter;
use App\Models\Game;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $perPage = in_array($perPage, [15, 25, 50, 100]) ? $perPage : 15;
        
        // Если нет сортировки, используем сортировку по умолчанию
        if (!$request->has('sort_by')) {
            $request->merge(['sort_by' => 'start_at', 'sort_direction' => 'desc']);
        }
        
        $games = Game::with('stadium')
            ->filter(new GameFilter($request->all()))
            ->paginate($perPage)
            ->appends($request->query());

        return view('admin.games.index', compact('games'));
    }
}
