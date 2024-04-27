<?php

namespace App\Services;

use App\Enum\OportunityStatus;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Oportunity;
use App\Repositories\OportunityRepository;

class OportunityService
{
    /**
     * @var \App\Repositories\OportunityRepository
     */
    protected $oportunityRepository;

    /**
     * @param OportunityRepository $oportunityRepository
     */
    public function __construct(OportunityRepository $oportunityRepository)
    {
        $this->oportunityRepository = $oportunityRepository;
    }

    /**
     * @param Company|null $company
     * @param Contact|null $contact
     * 
     * @return Oportunity
     */
    public function createNewOportunity(
        Company $company = null,
        Contact $contact = null
    ): Oportunity {
        $oportunityName = ($company) ? $company->nickname : 'Nova';

        $data = [
            'name' => "Oportunidade - $oportunityName",
            'company_id' => optional($company)->id,
            'contact_id' => optional($contact)->id,
            'status' => OportunityStatus::PROSPECTION(),
            'user_id' => backpack_user()->id,
            'date' => today()
        ];

        return $this->oportunityRepository->store($data);
    }

    /**
     * @param Oportunity $model
     * @param array $data
     * 
     * @return void
     */
    public function updateStatus(Oportunity $model, array $data): void
    {
        $this->oportunityRepository->update($model, ['status' => $data['status']]);
    }
}