<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $guarded = false;

    public function tickets()
    {
        return $this->hasMany(\App\Models\Ticket::class);
    }
}
