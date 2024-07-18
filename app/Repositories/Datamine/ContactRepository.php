<?php

namespace App\Repositories;

use App\Models\Contact;

class ContactRepository
{
    /**
     * @param array $data
     * 
     * @return Contact
     */
    public function store(array $data): Contact
    {
        return Contact::create($data);
    }
}