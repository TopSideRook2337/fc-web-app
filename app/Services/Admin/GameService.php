<?php

namespace App\Services\Admin;

use App\Models\Game;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class GameService
{
    public function store(array $data): Game
    {
        // Обрабатываем загрузку логотипов команд
        if (isset($data['home_team_logo']) && $data['home_team_logo'] instanceof UploadedFile) {
            $data['home_team_logo_path'] = $this->storeLogo($data['home_team_logo'], 'home');
            unset($data['home_team_logo']);
        }
        
        if (isset($data['away_team_logo']) && $data['away_team_logo'] instanceof UploadedFile) {
            $data['away_team_logo_path'] = $this->storeLogo($data['away_team_logo'], 'away');
            unset($data['away_team_logo']);
        }
        
        // Устанавливаем статус по умолчанию
        if (!isset($data['status'])) {
            $data['status'] = 'draft';
        }
        
        return Game::create($data);
    }
    
    public function update(Game $game, array $data): Game
    {
        // Обрабатываем загрузку логотипов команд
        if (isset($data['home_team_logo']) && $data['home_team_logo'] instanceof UploadedFile) {
            // Удаляем старый логотип
            if ($game->home_team_logo_path) {
                Storage::disk('public')->delete($game->home_team_logo_path);
            }
            $data['home_team_logo_path'] = $this->storeLogo($data['home_team_logo'], 'home');
            unset($data['home_team_logo']);
        }
        
        if (isset($data['away_team_logo']) && $data['away_team_logo'] instanceof UploadedFile) {
            // Удаляем старый логотип
            if ($game->away_team_logo_path) {
                Storage::disk('public')->delete($game->away_team_logo_path);
            }
            $data['away_team_logo_path'] = $this->storeLogo($data['away_team_logo'], 'away');
            unset($data['away_team_logo']);
        }
        
        // Устанавливаем статус по умолчанию если не указан
        if (!isset($data['status'])) {
            $data['status'] = $game->status;
        }
        
        $game->update($data);
        
        return $game;
    }
    
    private function storeLogo(UploadedFile $logo, string $team): string
    {
        $filename = time() . '_' . $team . '_' . $logo->getClientOriginalName();
        return $logo->storeAs('games/logos', $filename, 'public');
    }
}
