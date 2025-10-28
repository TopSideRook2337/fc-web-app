<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use HasFactory;

    protected $table = 'seats';
    protected $guarded = false;

    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
