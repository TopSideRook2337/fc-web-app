<?php

namespace App\Http\Controllers\Api\Games;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Sector;
use App\Models\Seat;
use App\Models\Ticket;
use Illuminate\Http\Request;

class SectorSeatsController extends Controller
{
    /**
     * Возвращает места выбранного сектора в контексте матча.
     * Параметры:
     * - onlyAvailable=1 — вернуть только доступные места.
     * - include=coords — добавить координаты x/y (для отрисовки).
     */
    public function __invoke(Request $request, int $gameId, int $sectorId)
    {
        $game = Game::findOrFail($gameId);
        $sector = Sector::where('id', $sectorId)
            ->where('stadium_id', $game->stadium_id)
            ->firstOrFail();

        // Находим занятые места в рамках матча
        $busySeatIds = Ticket::query()
            ->where('game_id', $game->id)
            ->where(function ($q) {
                $q->where('status', 'paid')
                    ->orWhere(function ($q2) {
                        $q2->where('status', 'reserved')
                           ->where('reservation_expires_at', '>', now());
                    });
            })
            ->pluck('seat_id')
            ->all();
        $busySeatIdSet = array_flip($busySeatIds);

        $onlyAvailable = (bool) $request->boolean('onlyAvailable', false);
        $includeCoords = collect((array) $request->input('include'))->contains('coords')
            || $request->input('include') === 'coords';

        $seatsQuery = Seat::query()
            ->where('sector_id', $sector->id)
            ->where('is_active', true)
            ->select(['id', 'row', 'number', 'x_coord', 'y_coord']);

        // Если нужны только доступные — исключаем занятые
        if ($onlyAvailable && !empty($busySeatIdSet)) {
            $seatsQuery->whereNotIn('id', array_keys($busySeatIdSet));
        }

        $seats = $seatsQuery
            ->orderBy('row')
            ->orderBy('number')
            ->get();

        $data = $seats->map(function (Seat $seat) use ($includeCoords, $busySeatIdSet, $sector) {
            $isAvailable = !isset($busySeatIdSet[$seat->id]);
            $item = [
                'id' => $seat->id,
                'row' => $seat->row,
                'number' => $seat->number,
                'is_available' => $isAvailable,
                'price' => (float) $sector->price_per_seat,
            ];

            if ($includeCoords) {
                $item['x'] = $seat->x_coord;
                $item['y'] = $seat->y_coord;
            }

            return $item;
        })->values();

        return response()->json(['data' => $data]);
    }
}




