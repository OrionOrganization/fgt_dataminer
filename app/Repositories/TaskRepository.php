<?php

namespace App\Repositories;

use App\Models\Task;

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
}