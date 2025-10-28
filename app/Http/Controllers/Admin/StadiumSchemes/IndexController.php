<?php

namespace App\Http\Controllers\Admin\StadiumSchemes;

use App\Http\Controllers\Controller;
use App\Models\Stadium;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        
        if (!in_array($perPage, [10, 15, 25, 50, 100])) {
            $perPage = 15;
        }

        $stadiums = Stadium::query()
            ->whereNotNull('schema_svg_path')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage)
            ->appends($request->query());

        return view('admin.stadium-schemes.index', compact('stadiums'));
    }
}
