<?php

namespace App\Http\Controllers\Admin\StadiumSchemes;

use App\Http\Controllers\Controller;
use App\Models\Stadium;

class UploadController extends Controller
{
    public function __invoke()
    {
        $stadiums = Stadium::all();
        
        return view('admin.stadium-schemes.upload', compact('stadiums'));
    }
}

