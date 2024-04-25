<?php

namespace App\Http\Controllers\Datamine;

use App\Http\Requests\DataMineEntityValueRequest;
use App\Traits\Crud\HandlesCrudFields;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class DatamineEntityValueCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class DatamineEntityValueCrudController extends CrudController
{
    use HandlesCrudFields;

    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Datamine\DatamineEntityValue::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/datamine/entity-value');
        CRUD::setEntityNameStrings('valor', 'valores');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::addColumn([
            'name' => 'value_all',
            'label' => 'Valor Total',
            'type' => 'closure',
            'function' => function($entry) {
                return $this->money($entry->value_all);
            }
        ]);

        CRUD::addColumn([
            'name' => 'value_indicador_ajuizado',
            'label' => 'Valor Ajuizado',
            'type' => 'closure',
            'function' => function($entry) {
                return $this->money($entry->value_indicador_ajuizado);
            }
        ]);

        CRUD::addColumn([
            'name' => 'value_n_indicador_ajuizado',
            'label' => 'Valor Não Ajuizado',
            'type' => 'closure',
            'function' => function($entry) {
                return $this->money($entry->value_n_indicador_ajuizado);
            }
        ]);

        CRUD::addColumn([
            'name' => 'value_type_tax_benefit',
            'label' => 'Benefício Fiscal',
            'type' => 'closure',
            'function' => function($entry) {
                return $this->money($entry->value_type_tax_benefit);
            }
        ]);

        CRUD::addColumn([
            'name' => 'value_type_in_collection',
            'label' => 'Em Cobrança',
            'type' => 'closure',
            'function' => function($entry) {
                return $this->money($entry->value_type_in_collection);
            }
        ]);

        CRUD::addColumn([
            'name' => 'value_type_in_negociation',
            'label' => 'Em Negociação',
            'type' => 'closure',
            'function' => function($entry) {
                return $this->money($entry->value_type_in_negociation);
            }
        ]);

        CRUD::addColumn([
            'name' => 'value_type_guarantee',
            'label' => 'Garantia',
            'type' => 'closure',
            'function' => function($entry) {
                return $this->money($entry->value_type_guarantee);
            }
        ]);

        CRUD::addColumn([
            'name' => 'value_type_suspended',
            'label' => 'Suspenso',
            'type' => 'closure',
            'function' => function($entry) {
                return $this->money($entry->value_type_suspended);
            }
        ]);

        CRUD::addColumn([
            'name' => 'value_type_others',
            'label' => 'Outros',
            'type' => 'closure',
            'function' => function($entry) {
                return $this->money($entry->value_type_others);
            }
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
        CRUD::setValidation(DataMineEntityValueRequest::class);

        

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
}
