<?php

namespace App\Http\Controllers\Admin\LoyaltyPoints;

use App\Http\Controllers\Controller;
use App\Models\LoyaltyPoint;

class ShowController extends Controller
{
    public function __invoke(LoyaltyPoint $loyaltyPoint)
    {
        $loyaltyPoint->load(['user', 'order']);
        
        return view('admin.loyalty-points.show', compact('loyaltyPoint'));
    }
}







