<?php

namespace App\Http\Controllers\Admin;

use App\Enum\TaskStatus;
use App\Enum\TaskType;
use App\Http\Requests\TaskRequest;
use App\Models\Oportunity;
use App\Models\Task;
use App\Models\User;
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
            'name' => 'oportunity_id',
            'label' => 'Oportunidade',
            'attribute' => 'name',
            'entity' => 'oportunity',
            'allows_null' => false,
            'wrapper'   => [
                'href' => function ($crud, $column, $entry, $related_key) {
                    return backpack_url('oportunity/'.$related_key.'/show');
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
        CRUD::column('due_date')->type('date')->label('Data');
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
        CRUD::column('obs')->label('Observação');
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

        $this->setupFilters();
    }

    protected function setupFilters()
    {
        $this->crud->addFilter(
            [
                'type'  => 'text',
                'name'  => 'id',
                'label' => 'ID'
            ], 
            false, 
            function($value) {
                $this->crud->addClause('where', 'id', 'LIKE', "%$value%");
            }
        );

        $this->crud->addFilter(
            [
                'type'  => 'text',
                'name'  => 'name',
                'label' => 'Título'
            ], 
            false, 
            function($value) {
                $this->crud->addClause('where', 'name', 'LIKE', "%$value%");
            }
        );

        $this->crud->addFilter(
            [
                'name' => 'oportunity_id',
                'type' => 'select2_ajax',
                'label' => 'Oportunidade',
                'placeholder' => 'Selecione uma oportunidade'
            ],
            backpack_url('oportunity/ajax-oportunity-options')
        );

        $this->crud->addFilter(
            [
                'name'  => 'user_id',
                'type'  => 'select2',
                'label' => 'Responsável'
            ],
            function () {
                return User::all()->keyBy('id')->pluck('name', 'id')->toArray();
            }
        );

        $this->crud->addFilter(
            [
                'type'  => 'date_range',
                'name'  => 'due_date',
                'label' => 'Data'
            ],
            false,
            function ($value) {
                $dates = json_decode($value);
                $this->crud->addClause('where', 'due_date', '>=', $dates->from);
                $this->crud->addClause('where', 'due_date', '<=', $dates->to . ' 23:59:59');
            }
        );

        $this->crud->addFilter(
            [
                'name'  => 'type',
                'type'  => 'dropdown',
                'label' => 'Tipo'
            ],
            TaskType::labels(),
            function($value) {
                $this->crud->addClause('where', 'type', $value);
            }
        );

        $this->crud->addFilter(
            [
                'name'  => 'status',
                'type'  => 'dropdown',
                'label' => 'Status'
            ],
            TaskStatus::labels(),
            function($value) {
                $this->crud->addClause('where', 'status', $value);
            }
        );
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
            'name' => 'oportunity_id',
            'label' => 'Oportunidade',
            'attribute' => 'name',
            'entity' => 'oportunity',
            'allows_null' => true,
        ]);
        CRUD::addField([
            'type' => 'relationship',
            'name' => 'user_id',
            'label' => 'Responsável',
            'attribute' => 'name',
            'entity' => 'responsible',
            'allows_null' => true,
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
        CRUD::field('obs')->label('Observação');

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

    /**
     * @param Request $request
     * @param Oportunity $model
     * 
     * @return JsonResponse
     */
    public function createTaskByOportunity(Request $request, Oportunity $model): JsonResponse
    {
        try {
            $this->taskService->createTaskByOportunity($model);

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
