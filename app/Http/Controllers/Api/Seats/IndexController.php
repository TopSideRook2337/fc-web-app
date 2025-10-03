<?php

namespace App\Http\Controllers\Api\Seats;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Post;
use App\Models\Seat;
use App\Models\Ticket;
use Illuminate\Http\Request;


class IndexController extends Controller
{
    public function __invoke(Request $request, $matchId)
    {
        $match = Game::findOrFail($matchId);

        $allSeats = Seat::whereHas('sector.stadium.matches', function ($q) use ($matchId) {
            $q->where('matches.id', $matchId);
        })->with('sector')->get();

        $soldSeatIds = Ticket::where('match_id', $matchId)
            ->whereIn('status', ['paid', 'reserved'])
            ->pluck('seat_id');

        $seats = $allSeats->map(function ($seat) use ($soldSeatIds) {
            return [
                'id' => $seat->id,
                'row' => $seat->row,
                'number' => $seat->number,
                'sector' => $seat->sector->name,
                'price' => $seat->sector->price_per_seat,
                'x' => $seat->x_coord,
                'y' => $seat->y_coord,
                'is_available' => !$soldSeatIds->contains($seat->id),
            ];
        });

        return response()->json($seats);
    }
}
