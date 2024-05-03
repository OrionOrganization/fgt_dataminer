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
     * @return Collection
     */
    public function getTasksGroupedByStatus(): Collection
    {
        return Task::with('responsible')->with('oportunity')->get()->groupBy('status');
    }
}