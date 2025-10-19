<?php

namespace App\Models;

use App\Http\Filters\FilterInterface;
use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory, Filterable;

    protected $table = 'posts';
    protected $guarded = false;
    public $timestamps = true;
    
    protected $fillable = [
        'title',
        'slug',
        'author_name',
        'excerpt',
        'content',
        'status',
        'published_at',
        'author_id',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function scopeFilter($query, FilterInterface $filter)
    {
        return $filter->apply($query);
    }
}
