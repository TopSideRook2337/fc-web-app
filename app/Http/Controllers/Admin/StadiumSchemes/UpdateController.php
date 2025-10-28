<?php

namespace App\Http\Controllers\Admin\StadiumSchemes;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StadiumSchemes\EditRequest;
use App\Models\Stadium;
use App\Services\Admin\StadiumSchemeService;

class UpdateController extends Controller
{
    public function __invoke(EditRequest $request, Stadium $stadium, StadiumSchemeService $service)
    {
        $service->updateSectorCoordinates($stadium, $request->validated()['sector_coordinates']);
        
        return redirect()
            ->route('admin.stadium-schemes.preview', $stadium)
            ->with('success', 'Координаты секторов успешно обновлены.');
    }
}

