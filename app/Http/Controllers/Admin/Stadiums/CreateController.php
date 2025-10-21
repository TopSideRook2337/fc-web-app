<?php

namespace App\Http\Controllers\Admin\Stadiums;

use App\Http\Controllers\Controller;

class CreateController extends Controller
{
    public function __invoke()
    {
        return view('admin.stadiums.create');
    }
}
