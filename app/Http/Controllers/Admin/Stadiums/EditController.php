<?php

namespace App\Http\Controllers\Admin\Stadiums;

use App\Http\Controllers\Controller;
use App\Models\Stadium;

class EditController extends Controller
{
    public function __invoke(Stadium $stadium)
    {
        return view('admin.stadiums.edit', compact('stadium'));
    }
}
