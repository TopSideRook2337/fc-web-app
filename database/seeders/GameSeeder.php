<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Stadium;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stadiums = Stadium::where('is_active', true)->get();
        
        if ($stadiums->isEmpty()) {
            // Создаем тестовый стадион если нет активных
            $stadium = Stadium::create([
                'name' => 'Тестовый стадион',
                'address' => 'г. Москва, ул. Тестовая, 1',
                'total_capacity' => 50000,
                'is_active' => true,
            ]);
        } else {
            $stadium = $stadiums->first();
        }

        $games = [
            [
                'title' => 'Дерби Реал - Барселона',
                'home_team_name' => 'Реал Мадрид',
                'away_team_name' => 'Барселона',
                'start_at' => Carbon::now()->addDays(7)->setTime(20, 0),
                'status' => 'tickets_open',
                'stadium_id' => $stadium->id,
            ],
            [
                'title' => 'Манчестер Юнайтед - Ливерпуль',
                'home_team_name' => 'Манчестер Юнайтед',
                'away_team_name' => 'Ливерпуль',
                'start_at' => Carbon::now()->addDays(14)->setTime(17, 30),
                'status' => 'tickets_open',
                'stadium_id' => $stadium->id,
            ],
            [
                'title' => 'Челси - Арсенал',
                'home_team_name' => 'Челси',
                'away_team_name' => 'Арсенал',
                'start_at' => Carbon::now()->addDays(21)->setTime(16, 0),
                'status' => 'draft',
                'stadium_id' => $stadium->id,
            ],
            [
                'title' => 'ПСЖ - Марсель',
                'home_team_name' => 'ПСЖ',
                'away_team_name' => 'Марсель',
                'start_at' => Carbon::now()->addDays(28)->setTime(21, 0),
                'status' => 'tickets_open',
                'stadium_id' => $stadium->id,
            ],
            [
                'title' => 'Бавария - Боруссия Дортмунд',
                'home_team_name' => 'Бавария',
                'away_team_name' => 'Боруссия Дортмунд',
                'start_at' => Carbon::now()->addDays(35)->setTime(18, 30),
                'status' => 'ready',
                'stadium_id' => $stadium->id,
            ],
            [
                'title' => 'Ювентус - Милан',
                'home_team_name' => 'Ювентус',
                'away_team_name' => 'Милан',
                'start_at' => Carbon::now()->addDays(42)->setTime(20, 45),
                'status' => 'cancelled',
                'stadium_id' => $stadium->id,
            ],
            [
                'title' => 'Атлетико Мадрид - Севилья',
                'home_team_name' => 'Атлетико Мадрид',
                'away_team_name' => 'Севилья',
                'start_at' => Carbon::now()->addDays(49)->setTime(19, 0),
                'status' => 'tickets_open',
                'stadium_id' => $stadium->id,
            ],
            [
                'title' => 'Интер - Наполи',
                'home_team_name' => 'Интер',
                'away_team_name' => 'Наполи',
                'start_at' => Carbon::now()->addDays(56)->setTime(21, 0),
                'status' => 'completed',
                'stadium_id' => $stadium->id,
            ],
            [
                'title' => 'Тоттенхэм - Манчестер Сити',
                'home_team_name' => 'Тоттенхэм',
                'away_team_name' => 'Манчестер Сити',
                'start_at' => Carbon::now()->addDays(63)->setTime(15, 0),
                'status' => 'draft',
                'stadium_id' => $stadium->id,
            ],
            [
                'title' => 'Аякс - ПСВ',
                'home_team_name' => 'Аякс',
                'away_team_name' => 'ПСВ',
                'start_at' => Carbon::now()->addDays(70)->setTime(20, 0),
                'status' => 'tickets_open',
                'stadium_id' => $stadium->id,
            ],
        ];

        foreach ($games as $game) {
            Game::create($game);
        }
    }
}
