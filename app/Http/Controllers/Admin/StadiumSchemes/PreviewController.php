<?php

namespace App\Http\Controllers\Admin\StadiumSchemes;

use App\Http\Controllers\Controller;
use App\Models\Stadium;

class PreviewController extends Controller
{
    public function __invoke(Stadium $stadium)
    {
        if (!$stadium->schema_svg_path) {
            return redirect()
                ->route('admin.stadium-schemes.index')
                ->with('error', 'Схема для данного стадиона не найдена.');
        }
        
        return view('admin.stadium-schemes.preview', compact('stadium'));
    }
}
