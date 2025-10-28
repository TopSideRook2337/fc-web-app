<?php

namespace App\Services\Admin;

use App\Models\Stadium;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class StadiumSchemeService
{
    public function uploadSvg(Stadium $stadium, UploadedFile $svg): Stadium
    {
        $directory = "stadiums/{$stadium->id}";
        $filename = 'scheme.svg';
        
        // Создаем директорию если не существует
        Storage::disk('public')->makeDirectory($directory);
        
        // Сохраняем файл
        $path = $svg->storeAs($directory, $filename, 'public');
        
        // Обновляем путь к схеме в базе данных
        $stadium->update(['schema_svg_path' => $path]);
        
        return $stadium->fresh();
    }

    public function parseSvgForSectors(string $svgPath): array
    {
        $fullPath = Storage::disk('public')->path($svgPath);
        
        if (!file_exists($fullPath)) {
            return [];
        }
        
        $svgContent = file_get_contents($fullPath);
        
        // Простой парсинг SVG для поиска элементов с data-sector атрибутами
        $sectors = [];
        
        // Ищем все элементы с data-sector атрибутом
        preg_match_all('/<[^>]+data-sector="([^"]+)"[^>]*>/', $svgContent, $matches);
        
        foreach ($matches[1] as $sectorId) {
            // Ищем координаты элемента (упрощенно - берем первые найденные x,y)
            $pattern = '/<[^>]*data-sector="' . preg_quote($sectorId, '/') . '"[^>]*>/';
            preg_match($pattern, $svgContent, $elementMatch);
            
            if ($elementMatch) {
                $element = $elementMatch[0];
                
                // Пытаемся извлечь координаты из различных атрибутов
                $x = $this->extractCoordinate($element, 'x') ?? $this->extractCoordinate($element, 'cx') ?? 0;
                $y = $this->extractCoordinate($element, 'y') ?? $this->extractCoordinate($element, 'cy') ?? 0;
                
                $sectors[$sectorId] = [
                    'x' => (float) $x,
                    'y' => (float) $y,
                ];
            }
        }
        
        return $sectors;
    }

    public function updateSectorCoordinates(Stadium $stadium, array $coordinates): Stadium
    {
        $stadium->update(['sector_coordinates' => json_encode($coordinates)]);
        
        return $stadium->fresh();
    }

    private function extractCoordinate(string $element, string $attribute): ?string
    {
        preg_match('/' . preg_quote($attribute, '/') . '="([^"]+)"/', $element, $matches);
        
        return $matches[1] ?? null;
    }
}
