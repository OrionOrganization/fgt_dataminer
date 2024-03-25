<?php

namespace App\Repositories;

use App\Models\Company;

class CompanyRepository
{
    /**
     * @param array $data
     * 
     * @return Company
     */
    public function store(array $data): Company
    {
        return Company::create($data);
    }
}