<?php

namespace App\Http\Controllers\Admin\Stadiums;

use App\Http\Controllers\Controller;
use App\Models\Stadium;
use Illuminate\Http\RedirectResponse;

class DestroyController extends Controller
{
    public function __invoke(Stadium $stadium): RedirectResponse
    {
        $stadium->delete();

        return redirect()
            ->route('admin.stadiums.index')
            ->with('success', 'Стадион успешно удален!');
    }
}
