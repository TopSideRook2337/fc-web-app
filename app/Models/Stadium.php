<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stadium extends Model
{
    use HasFactory, Filterable;

    protected $table = 'stadiums';
    protected $guarded = false;
    
    protected $casts = [
        'sector_coordinates' => 'array',
    ];

    public function sectors()
    {
        return $this->hasMany(Sector::class);
    }

    public function games()
    {
        return $this->hasMany(Game::class);
    }
}
