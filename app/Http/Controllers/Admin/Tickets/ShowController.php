<?php

namespace App\Http\Controllers\Admin\Tickets;

use App\Http\Controllers\Controller;
use App\Models\Ticket;

class ShowController extends Controller
{
    public function __invoke(Ticket $ticket)
    {
        $ticket->load([
            'game.stadium',
            'seat.sector',
            'order.user',
            'order.orderItems'
        ]);

        return view('admin.tickets.show', compact('ticket'));
    }
}

