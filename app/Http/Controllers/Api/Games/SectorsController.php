<?php

namespace App\Http\Controllers\Api\Games;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Sector;
use App\Models\Ticket;
use Illuminate\Http\Request;

class SectorsController extends Controller
{
    /**
     * Возвращает список секторов для выбранного матча.
     * Логика:
     * - Берём матч и его стадион.
     * - Получаем все активные секторы стадиона.
     * - Находим занятые места (paid + актуальные reserved) по этому матчу.
     * - Считаем доступность по каждому сектору.
     */
    public function __invoke(Request $request, int $gameId)
    {
        // Загружаем матч вместе со стадионом
        $game = Game::with('stadium')->findOrFail($gameId);

        // Берём активные секторы стадиона
        $sectors = Sector::query()
            ->where('stadium_id', $game->stadium_id)
            ->where('is_active', true)
            ->get(['id', 'name', 'color', 'price_per_seat']);

        if ($sectors->isEmpty()) {
            return response()->json(['data' => []]);
        }

        // Для оценки доступности найдём занятые места в рамках матча
        $busySeatIds = Ticket::query()
            ->where('game_id', $game->id)
            ->where(function ($q) {
                // Место занято, если билет оплачен
                $q->where('status', 'paid')
                    // или если билет в резерве и резерв ещё не истёк
                    ->orWhere(function ($q2) {
                        $q2->where('status', 'reserved')
                           ->where('reservation_expires_at', '>', now());
                    });
            })
            ->pluck('seat_id')
            ->all();

        // Индекс занятых мест для быстрых проверок
        $busySeatIdSet = array_flip($busySeatIds);

        // Для каждого сектора посчитаем capacity и available
        $result = $sectors->map(function (Sector $sector) use ($busySeatIdSet) {
            $totalSeats = $sector->seats()->count();
            $busyInSector = $sector->seats()
                ->whereIn('id', array_keys($busySeatIdSet))
                ->count();
            $available = max($totalSeats - $busyInSector, 0);

            return [
                'id' => $sector->id,
                'name' => $sector->name,
                'color' => $sector->color,
                'price_per_seat' => (float) $sector->price_per_seat,
                'capacity' => $totalSeats,
                'available' => $available,
            ];
        })->values();

        return response()->json(['data' => $result]);
    }
}




