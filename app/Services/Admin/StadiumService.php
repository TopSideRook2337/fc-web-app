<?php

namespace App\Services\Admin;

use App\Models\Stadium;

class StadiumService
{
    public function store(array $data): Stadium
    {
        return Stadium::create($data);
    }

    public function update(Stadium $stadium, array $data): Stadium
    {
        $stadium->update($data);
        
        return $stadium->fresh();
    }
}
