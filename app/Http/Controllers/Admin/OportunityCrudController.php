<?php

namespace App\Http\Controllers\Admin;

use App\Enum\OportunityStatus;
use App\Http\Requests\OportunityRequest;
use App\Models\Oportunity;
use App\Services\OportunityService;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class OportunityCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class OportunityCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * @var \App\Services\OportunityService
     */
    protected $oportunityService;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Oportunity::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/oportunity');
        CRUD::setEntityNameStrings('oportunidade', 'Oportunidades');

        $this->oportunityService = resolve(OportunityService::class);
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
        CRUD::column('name')->label('Nome');
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
            'name' => 'contact_id',
            'label' => 'Contato',
            'attribute' => 'name',
            'entity' => 'contact',
            'wrapper'   => [
                'href' => function ($crud, $column, $entry, $related_key) {
                    return backpack_url('contact/'.$related_key.'/show');
                },
            ],
        ]);
        CRUD::addColumn([
            'name' => 'status',
            'type' => 'closure',
            'function' => function($entry) {
                return OportunityStatus::from($entry->status)->getLabel();
            }
        ]);
        CRUD::addColumn([
            'type' => 'relationship',
            'name' => 'user_id',
            'label' => 'Responsável',
            'attribute' => 'name',
            'entity' => 'responsible',
        ]);
        CRUD::column('date')->label('Data')->type('date');
        CRUD::column('obs')->label('Observações');
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
        CRUD::setValidation(OportunityRequest::class);

        CRUD::field('name')->label('Nome');
        CRUD::addField([
            'type' => 'relationship',
            'name' => 'company_id',
            'label' => 'Empresa',
            'attribute' => 'nickname',
            'entity' => 'company',
            'allows_null' => true,
            'default' => null
        ]);
        CRUD::addField([
            'type' => 'relationship',
            'name' => 'contact_id',
            'label' => 'Contato',
            'attribute' => 'name',
            'entity' => 'contact',
            'allows_null' => true,
            'default' => null
        ]);
        CRUD::addField([
            'name' => 'status',
            'type' => 'select_from_array',
            'options' => OportunityStatus::labels(),
            'allows_null' => false,
        ]);
        CRUD::addField([
            'type' => 'relationship',
            'name' => 'user_id',
            'label' => 'Responsável',
            'attribute' => 'name',
            'entity' => 'responsible',
        ]);
        CRUD::field('date')->label('Data');
        CRUD::field('obs')->label('Observações');

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
     * @param Oportunity $model
     * 
     * @return JsonResponse
     */
    public function updateOportunityStatus(Request $request, Oportunity $model): JsonResponse
    {
        try {
            $input = $request->all();
            $this->oportunityService->updateStatus($model, $input);

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
