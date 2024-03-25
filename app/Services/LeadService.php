<?php

namespace App\Services;

use App\Models\Contact;
use App\Models\Company;
use App\Models\Lead;
use App\Repositories\ContactRepository;
use App\Repositories\CompanyRepository;

class LeadService
{
    /**
     * @var \App\Repositories\CompanyRepository
     */
    protected $companyRepository;

    /**
     * @var \App\Repositories\ContactRepository
     */
    protected $contactRepository;

    /**
     * @var \App\Services\OportunityService
     */
    protected $oportunityService;

    public function __construct(
        CompanyRepository $companyRepository,
        ContactRepository $contactRepository,
        OportunityService $oportunityService
    ) {
        $this->companyRepository = $companyRepository;
        $this->contactRepository = $contactRepository;
        $this->oportunityService = $oportunityService;
    }

    /**
     * @param Lead $lead
     * 
     * @return void
     */
    public function convertLead(Lead $lead): void
    {
        $company = $this->createCompanyByLead($lead);
        $contact = $this->createContactByLead($lead, $company);

        $this->oportunityService->createNewOportunity($company, $contact);
    }

    /**
     * @param Lead $lead
     * @param array $data
     * 
     * @return Company
     */
    public function createCompanyByLead(Lead $lead): Company
    {
        $companyData = [
            'cnpj' => $lead->cnpj,
            'nickname' => $lead->company_name,
            'description' => 'Empresa criada automaticamente',
            'user_id' => backpack_user()->id
        ];

        return $this->companyRepository->store($companyData);
    }

    /**
     * @param Lead $lead
     * @param Company $company
     * 
     * @return Contact
     */
    public function createContactByLead(Lead $lead, Company $company): Contact
    {
        $data = [
            'company_id' => $company->id,
            'name' => $lead->name,
            'phone' => $lead->phone,
            'email' => $lead->email
        ];

        return $this->contactRepository->store($data);
    }
}