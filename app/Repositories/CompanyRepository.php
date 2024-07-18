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

    /**
     * @param array $data
     * 
     * @return Company
     */
    public function updateOrCreate(array $data): Company
    {
        $data['deleted_at'] = null;
        return Company::withTrashed()->updateOrCreate(['cnpj' => $data['cnpj']], $data);
    }
}