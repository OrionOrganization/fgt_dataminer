<?php

namespace App\Services;

use App\Models\Contact;
use App\Models\Company;
use App\Models\Lead;
use App\Services\Crm\CompanyService;
use App\Services\Crm\ContactService;

class LeadService
{
    /**
     * @var \App\Services\OportunityService
     */
    protected $oportunityService;

    /**
     * @var \App\Services\Crm\CompanyService
     */
    protected $companyService;

    /**
     * @var \App\Services\Crm\ContactService
     */
    protected $contactService;

    public function __construct(
        OportunityService $oportunityService,
        CompanyService $companyService,
        ContactService $contactService
    ) {
        $this->oportunityService = $oportunityService;
        $this->companyService = $companyService;
        $this->contactService = $contactService;
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

        return $this->companyService->createOrUpdateCompany($companyData);
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

        return $this->contactService->createNewContact($data);
    }
}