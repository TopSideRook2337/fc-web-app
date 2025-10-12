<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stadium extends Model
{
    use HasFactory;

    protected $table = 'stadiums';
    protected $guarded = false;

    public function sectors()
    {
        return $this->hasMany(Sector::class);
    }

    public function games()
    {
        return $this->hasMany(Game::class);
    }
}
