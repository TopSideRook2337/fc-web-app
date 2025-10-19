<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'tickets';
    protected $guarded = false;

    protected $casts = [
        'reservation_expires_at' => 'datetime',
    ];


    public function game()
    {
        return $this->belongsTo(Game::class, 'game_id');
    }
}
