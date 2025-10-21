<?php

namespace App\Http\Controllers\Admin\Stadiums;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Stadiums\UpdateRequest;
use App\Models\Stadium;
use App\Services\Admin\StadiumService;
use Illuminate\Http\RedirectResponse;

class UpdateController extends Controller
{
    public function __construct(
        private StadiumService $stadiumService
    ) {}

    public function __invoke(UpdateRequest $request, Stadium $stadium): RedirectResponse
    {
        $data = $request->validated();
        
        // Преобразуем total_capacity в integer
        if (isset($data['total_capacity'])) {
            $data['total_capacity'] = (int) $data['total_capacity'];
        }
        
        $this->stadiumService->update($stadium, $data);

        return redirect()
            ->route('admin.stadiums.show', $stadium)
            ->with('success', 'Стадион успешно обновлен!');
    }
}
