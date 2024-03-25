<?php

namespace App\Repositories;

use App\Models\Oportunity;

class OportunityRepository
{
    /**
     * @param array $data
     * 
     * @return Oportunity
     */
    public function store(array $data): Oportunity
    {
        return Oportunity::create($data);
    }

    /**
     * @param Oportunity $model
     * @param array $data
     * 
     * @return void
     */
    public function update(Oportunity $model, array $data): void
    {
        $model->update($data);
    }
}