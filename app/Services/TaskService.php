<?php

namespace App\Services;

use App\Models\Task;
use App\Repositories\TaskRepository;

class TaskService
{
    /**
     * @var \App\Repositories\TaskRepository
     */
    protected $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * @param Task $model
     * @param array $data
     * 
     * @return void
     */
    public function updateStatus(Task $model, array $data): void
    {
        $this->taskRepository->update($model, ['status' => $data['status']]);
    }
}