<?php

namespace App\Http\Controllers\Admin\Tickets;

use App\Http\Controllers\Controller;
use App\Http\Filters\Admin\Tickets\TicketFilter;
use App\Models\Game;
use Illuminate\Http\Request;

class GameTicketsController extends Controller
{
    public function __invoke(Request $request, Game $game)
    {
        $perPage = $request->get('per_page', 15);
        $perPage = in_array($perPage, [15, 25, 50, 100]) ? $perPage : 15;
        
        $tickets = $game->tickets()
            ->with(['seat.sector', 'order.user'])
            ->filter(new TicketFilter($request))
            ->paginate($perPage)
            ->appends($request->query());

        // Получаем уникальные сектора для фильтра
        $sectors = $game->stadium->sectors;

        return view('admin.tickets.game-tickets', compact('tickets', 'game', 'sectors'));
    }
}

