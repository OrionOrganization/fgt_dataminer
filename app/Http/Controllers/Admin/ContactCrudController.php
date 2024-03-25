<?php

namespace App\Http\Controllers\Admin;

use App\Enum\ContactPosition;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;

/**
 * Class ContactCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ContactCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Contact::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/contact');
        CRUD::setEntityNameStrings('contato', 'contatos');
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
            'name' => 'company',
            'label' => 'Empresa',
            'attribute' => 'nickname',
            'entity' => 'company',
            'wrapper'   => [
                'href' => function ($crud, $column, $entry, $related_key) {
                    return backpack_url('company/'.$related_key.'/show');
                },
            ],
        ]);

        CRUD::column('phone')->label('Telefone');
        CRUD::column('email');
        CRUD::addColumn([
            'name' => 'position',
            'label' => 'Cargo',
            'type' => 'closure',
            'function' => function($entry) {
                return (!is_null($entry->position))
                        ? ContactPosition::from($entry->position)->getLabel()
                        : '';
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
                'label' => 'Nome'
            ], 
            false, 
            function($value) {
                $this->crud->addClause('where', 'name', 'LIKE', "%$value%");
            }
        );

        $this->crud->addFilter(
            [
                'name' => 'company_id',
                'type' => 'select2_ajax',
                'label' => 'Empresa',
                'placeholder' => 'Selecione uma empresa'
            ],
            backpack_url('company/ajax-company-options')
        );

        $this->crud->addFilter(
            [
                'type'  => 'text',
                'name'  => 'phone',
                'label' => 'Telefone'
            ], 
            false, 
            function($value) {
                $this->crud->addClause('where', 'phone', 'LIKE', "%$value%");
            }
        );

        $this->crud->addFilter(
            [
                'type'  => 'text',
                'name'  => 'email',
                'label' => 'Email'
            ], 
            false, 
            function($value) {
                $this->crud->addClause('where', 'email', 'LIKE', "%$value%");
            }
        );

        $this->crud->addFilter(
            [
                'name'  => 'position',
                'type'  => 'dropdown',
                'label' => 'Cargo'
            ],
            ContactPosition::labels(),
            function($value) {
                $this->crud->addClause('where', 'position', $value);
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
        CRUD::setValidation(ContactRequest::class);

        CRUD::field('name')->label('Nome');

        CRUD::addField([
            'type' => 'relationship',
            'name' => 'company',
            'label' => 'Empresa',
            'attribute' => 'nickname',
            'entity' => 'company',
         ]);

        CRUD::field('phone')->label('Telefone');
        CRUD::field('email')->type('email');

        CRUD::addField([
            'name' => 'position',
            'label' => 'Cargo',
            'type' => 'select_from_array',
            'options' => ContactPosition::labels(),
            'allows_null' => true,
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

    public function contactOptions(Request $request) {
        $term = $request->input('term');
        $options = Contact::where('name', 'like', '%'.$term.'%')->get()->pluck('name', 'id');
        return $options;
    }
}
