<?php

namespace App\Services;

use App\Enum\TaskStatus;
use App\Enum\TaskType;
use App\Models\Oportunity;
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

    /**
     * @param Oportunity $model
     * 
     * @return Task
     */
    public function createTaskByOportunity(Oportunity $model): Task
    {
        $data = [
            'name' => 'Tarefa: ' . $model->name,
            'oportunity_id' => $model->id,
            'user_id' => backpack_user()->id,
            'type' => TaskType::TEXT(),
            'status' => TaskStatus::NON_STARTED()
        ];

        return $this->taskRepository->store($data);
    }
}