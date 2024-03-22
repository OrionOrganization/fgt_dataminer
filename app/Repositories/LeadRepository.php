<?php

namespace App\Repositories;

use App\Models\Lead;

class LeadRepository
{
    /**
     * @param array $data
     * 
     * @return Lead
     */
    public function store(array $data): Lead
    {
        return Lead::create($data);
    }
}