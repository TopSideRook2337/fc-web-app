<?php

namespace App\Http\Controllers\Admin\StadiumSchemes;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StadiumSchemes\UploadRequest;
use App\Models\Stadium;
use App\Services\Admin\StadiumSchemeService;

class StoreController extends Controller
{
    public function __invoke(UploadRequest $request, StadiumSchemeService $service)
    {
        $stadium = Stadium::findOrFail($request->validated()['stadium_id']);
        
        $service->uploadSvg($stadium, $request->file('svg'));
        
        return redirect()
            ->route('admin.stadium-schemes.index')
            ->with('success', 'Схема стадиона успешно загружена.');
    }
}

