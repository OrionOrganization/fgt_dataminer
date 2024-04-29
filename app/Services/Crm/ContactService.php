<?php

namespace App\Services\Crm;

use App\Models\Contact;
use App\Repositories\ContactRepository;

class ContactService
{
    /**
     * @var \App\Repositories\ContactRepository
     */
    protected $contactRepository;

    public function __construct(ContactRepository $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }
    /**
     * @param array $data
     * 
     * @return Contact
     */
    public function createNewContact(array $data): Contact
    {
        return $this->contactRepository->store($data);
    }
}