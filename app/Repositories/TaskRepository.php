<?php

namespace App\Repositories;

use App\Models\Task;
use Illuminate\Support\Collection;

class TaskRepository
{
    /**
     * @param array $data
     * 
     * @return Task
     */
    public function store(array $data): Task
    {
        return Task::create($data);
    }

    /**
     * @param Task $model
     * @param array $data
     * 
     * @return void
     */
    public function update(Task $model, array $data): void
    {
        $model->update($data);
    }

    /**
     * @param array $filters
     * 
     * @return Collection
     */
    public function getTasksGroupedByStatus(array $filters): Collection
    {

        $query = Task::with('responsible')->with('oportunity');

        if (!empty($filters['task_user'])) {
            $query->where('user_id', $filters['task_user']);
        }

        if (!empty($filters['task_date'])) {
            $query->where('due_date', $filters['task_date']);
        }

        if (!empty($filters['task_order']) && !empty($filters['task_order_direction'])) {
            $query->orderBy($filters['task_order'], $filters['task_order_direction']);
        }

        return $query->get()->groupBy('status');
    }
}