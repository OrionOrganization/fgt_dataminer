<?php

namespace App\Http\Controllers\Admin;

use App\Enum\TaskStatus;
use App\Enum\TaskType;
use App\Http\Requests\TaskRequest;
use App\Models\Task;
use App\Services\TaskService;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class TaskCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class TaskCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * @var \App\Services\TaskService
     */
    protected $taskService;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Task::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/task');
        CRUD::setEntityNameStrings('tarefa', 'tarefas');

        $this->taskService = resolve(TaskService::class);
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('id');
        CRUD::column('name')->label('Título');
        CRUD::addColumn([
            'type' => 'relationship',
            'name' => 'company_id',
            'label' => 'Empresa',
            'attribute' => 'nickname',
            'entity' => 'company',
            'wrapper'   => [
                'href' => function ($crud, $column, $entry, $related_key) {
                    return backpack_url('company/'.$related_key.'/show');
                },
            ],
        ]);
        CRUD::addColumn([
            'type' => 'relationship',
            'name' => 'user_id',
            'label' => 'Responsável',
            'attribute' => 'name',
            'entity' => 'responsible',
        ]);
        CRUD::column('due_date')->label('Data');
        CRUD::addColumn([
            'name' => 'type',
            'label' => 'Tipo',
            'type' => 'closure',
            'function' => function($entry) {
                return TaskType::from($entry->type)->getLabel();
            }
        ]);
        CRUD::addColumn([
            'name' => 'status',
            'label' => 'Status',
            'type' => 'closure',
            'function' => function($entry) {
                return TaskStatus::from($entry->status)->getLabel();
            }
        ]);
        CRUD::addColumn([
            'name' => 'created_at',
            'label' => 'Criação',
            'type' => 'datetime'
        ]);

        CRUD::addColumn([
            'name' => 'updated_at',
            'label' => 'Atualização',
            'type' => 'datetime'
        ]);

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(TaskRequest::class);

        CRUD::field('name')->label('Título');
        CRUD::addField([
            'type' => 'relationship',
            'name' => 'company_id',
            'label' => 'Empresa',
            'attribute' => 'nickname',
            'entity' => 'company',
            'allows_null' => false,
        ]);
        CRUD::addField([
            'type' => 'relationship',
            'name' => 'user_id',
            'label' => 'Responsável',
            'attribute' => 'name',
            'entity' => 'responsible',
            'allows_null' => false,
        ]);
        CRUD::field('due_date')->label('Data Entrega');
        CRUD::addField([
            'name' => 'type',
            'label' => "Tipo",
            'type' => 'select_from_array',
            'options' => TaskType::labels(),
            'allows_null' => false,
        ]);
        CRUD::addField([
            'name' => 'status',
            'label' => "Status",
            'type' => 'select_from_array',
            'options' => TaskStatus::labels(),
            'allows_null' => false,
        ]);

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    protected function setupShowOperation()
    {
        $this->setupListOperation();
    }

    /**
     * @param Request $request
     * @param Task $model
     * 
     * @return JsonResponse
     */
    public function updateTaskStatus(Request $request, Task $model): JsonResponse
    {
        try {
            $input = $request->all();
            $this->taskService->updateStatus($model, $input);

            return response()->json([
                'success' => true
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ]);
        }
    }
}
