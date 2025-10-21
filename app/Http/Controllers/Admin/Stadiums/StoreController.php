<?php

namespace App\Http\Controllers\Admin\Stadiums;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Stadiums\StoreRequest;
use App\Services\Admin\StadiumService;
use Illuminate\Http\RedirectResponse;

class StoreController extends Controller
{
    public function __construct(
        private StadiumService $stadiumService
    ) {}

    public function __invoke(StoreRequest $request): RedirectResponse
    {
        $data = $request->validated();
        
        $stadium = $this->stadiumService->store($data);

        return redirect()
            ->route('admin.stadiums.show', $stadium)
            ->with('success', 'Стадион успешно создан!');
    }
}
