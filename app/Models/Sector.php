<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    use HasFactory;

    protected $table = 'sectors';
    protected $guarded = false;

    public function stadium()
    {
        return $this->belongsTo(Stadium::class);
    }

    public function seats()
    {
        return $this->hasMany(Seat::class);
    }
}
