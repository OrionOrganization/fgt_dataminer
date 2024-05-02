<?php

namespace App\Services\Crm;

use App\Models\Company;
use App\Repositories\CompanyRepository;

class CompanyService
{
    /**
     * @var \App\Repositories\CompanyRepository
     */
    protected $companyRepository;

    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }
    /**
     * @param array $data
     * 
     * @return Company
     */
    public function createNewCompany(array $data): Company
    {
        return $this->companyRepository->store($data);
    }

    /**
     * @param array $data
     * 
     * @return Company
     */
    public function createOrUpdateCompany(array $data): Company
    {
        return $this->companyRepository->updateOrCreate($data);
    }
}