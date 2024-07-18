<?php

namespace App\Repositories;

use App\Models\Oportunity;
use Illuminate\Support\Collection;

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

    /**
     * @param array $filters
     * 
     * @return Collection
     */
    public function getOportunitiesGroupedByStatus(array $filters): Collection
    {
        $query = Oportunity::with('company');

        if (!empty($filters['oportunity_user'])) {
            $query->where('user_id', $filters['oportunity_user']);
        }

        if (!empty($filters['oportunity_date'])) {
            $query->where('date', $filters['oportunity_date']);
        }

        if (!empty($filters['oportunity_order']) && !empty($filters['oportunity_order_direction'])) {
            $query->orderBy($filters['oportunity_order'], $filters['oportunity_order_direction']);
        }

        return $query->get()->groupBy('status');
    }
}