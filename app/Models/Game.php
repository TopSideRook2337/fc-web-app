<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;
    use Filterable;

    protected $table = 'games';
    protected $guarded = false;

    protected $casts = [
        'start_at' => 'datetime',
    ];

    public function stadium()
    {
        return $this->belongsTo(Stadium::class);
    }
}
