<?php

namespace App\Http\Controllers\Api\Orders;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;


class StoreController extends Controller
{
    public function __invoke(Request $request)
    {
        // Временная заглушка
        return response()->json([
            'message' => 'Order processing started. Full logic coming soon.'
        ], 201);
    }
}
