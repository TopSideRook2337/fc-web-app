<?php

namespace App\Http\Controllers\Api\Orders;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;


class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $orders = $request->user()->orders()->with('tickets.match')->get();

        return response()->json($orders);
    }
}
