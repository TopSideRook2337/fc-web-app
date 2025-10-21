<?php

namespace App\Http\Controllers\Admin\Stadiums;

use App\Http\Controllers\Controller;
use App\Models\Stadium;

class ShowController extends Controller
{
    public function __invoke(Stadium $stadium)
    {
        $stadium->load(['sectors.seats', 'games']);
        
        return view('admin.stadiums.show', compact('stadium'));
    }
}
