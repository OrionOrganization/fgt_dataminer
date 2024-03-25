<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\LeadRequest;
use App\Models\Lead;
use App\Services\LeadService;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Exception;
use Illuminate\Http\Request;

/**
 * Class LeadCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class LeadCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * @var \App\Services\LeadService
     */
    protected $leadService;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Lead::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/lead');
        CRUD::setEntityNameStrings('lead', 'leads');

        $this->crud->addButtonFromView('line', 'convert_lead', 'convert_lead', 'beginning');

        $this->leadService = resolve(LeadService::class);
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
        CRUD::column('company_name')->label('Nome Empresa');
        CRUD::column('phone')->label('Telefone');
        CRUD::column('email');
        CRUD::column('cnpj')->label('CNPJ');
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
        CRUD::setValidation(LeadRequest::class);

        CRUD::field('name')->label('Nome');
        CRUD::field('company_name')->label('Nome Empresa');
        CRUD::field('phone')->label('Telefone');
        CRUD::field('email');
        CRUD::field('cnpj')->label('CNPJ');

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

        CRUD::column('message')->label('Mensagem');
    }

    public function leadConvert(Request $request, Lead $model)
    {
        try {
            $this->leadService->convertLead($model);

            return response()->json([
                'success' => true,
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ], 400);
        }
    }
}
