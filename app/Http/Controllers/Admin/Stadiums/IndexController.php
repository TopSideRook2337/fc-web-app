<?php

namespace App\Http\Controllers\Admin\Stadiums;

use App\Http\Controllers\Controller;
use App\Models\Stadium;
use App\Http\Filters\Admin\Stadiums\StadiumFilter;
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
            ->filter(new StadiumFilter($request))
            ->orderBy('created_at', 'desc')
            ->paginate($perPage)
            ->appends($request->query());

        return view('admin.stadiums.index', compact('stadiums'));
    }
}
