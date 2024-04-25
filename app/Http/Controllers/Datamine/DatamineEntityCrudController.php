<?php

namespace App\Http\Controllers\Datamine;

use App\Enum\Datamine\CompanyTaxRegime;
use App\Enum\Datamine\DataMineEntitiesType;
use App\Http\Requests\DatamineEntityRequest;
use App\Traits\Crud\HandlesCrudFields;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class DatamineEntityCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class DatamineEntityCrudController extends CrudController
{
    use HandlesCrudFields;

    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
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
        CRUD::setModel(\App\Models\Datamine\DatamineEntity::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/datamine/entity');
        CRUD::setEntityNameStrings('entidade', 'entidades');
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
        CRUD::addColumn([
            'name' => 'key',
            'label' => 'Chave Principal',
        ]);
        CRUD::column('complete_cpf')->label('CPF Completo');

        CRUD::addColumn([
            'name' => 'type_entity',
            'label' => 'Tipo',
            'type' => 'closure',
            'function' => function($entry) {
                return DataMineEntitiesType::from($entry->type_entity)->getLabel();
            }
        ]);

        CRUD::addColumn([
            'name' => 'type_tax_regime',
            'label' => 'Regime Tributário',
            'type' => 'closure',
            'function' => function($entry) {
                return CompanyTaxRegime::from($entry->type_tax_regime)->getLabel();
            }
        ]);

        CRUD::column('code_ibge')->label('Cód. IBGE');

        CRUD::addColumn([
            'name' => 'value_all',
            'label' => 'Valor Total',
            'type' => 'closure',
            'function' => function($entry) {
                return $this->money($entry->value->value_all);
            }
        ]);

        CRUD::addColumn([
            'name' => 'value_indicador_ajuizado',
            'label' => 'Valor Ajuizado',
            'type' => 'closure',
            'function' => function($entry) {
                return $this->money($entry->value->value_indicador_ajuizado);
            }
        ]);

        CRUD::addColumn([
            'name' => 'value_n_indicador_ajuizado',
            'label' => 'Valor Não Ajuizado',
            'type' => 'closure',
            'function' => function($entry) {
                return $this->money($entry->value->value_n_indicador_ajuizado);
            }
        ]);

        CRUD::addColumn([
            'name' => 'value_type_tax_benefit',
            'label' => 'Valor Em Benefício Fiscal',
            'type' => 'closure',
            'function' => function($entry) {
                return $this->money($entry->value->value_type_tax_benefit);
            }
        ]);

        CRUD::addColumn([
            'name' => 'value_type_in_collection',
            'label' => 'Valor Em Cobrança',
            'type' => 'closure',
            'function' => function($entry) {
                return $this->money($entry->value->value_type_in_collection);
            }
        ]);

        CRUD::addColumn([
            'name' => 'value_type_in_negociation',
            'label' => 'Valor Em Negociação',
            'type' => 'closure',
            'function' => function($entry) {
                return $this->money($entry->value->value_type_in_negociation);
            }
        ]);

        CRUD::addColumn([
            'name' => 'value_type_guarantee',
            'label' => 'Valor Garantia',
            'type' => 'closure',
            'function' => function($entry) {
                return $this->money($entry->value->value_type_guarantee);
            }
        ]);

        CRUD::addColumn([
            'name' => 'value_type_suspended',
            'label' => 'Valor Suspenso',
            'type' => 'closure',
            'function' => function($entry) {
                return $this->money($entry->value->value_type_suspended);
            }
        ]);

        CRUD::addColumn([
            'name' => 'value_type_others',
            'label' => 'Outros',
            'type' => 'closure',
            'function' => function($entry) {
                return $this->money($entry->value->value_type_others);
            }
        ]);

        CRUD::column('address')->label('Endereço');

        $this->setupFilters();
    }

    protected function setupFilters()
    {
        $this->crud->addFilter(
            [
                'type'  => 'text',
                'name'  => 'key',
                'label' => 'Chave Principal'
            ],
            false,
            function ($value) {
                $this->crud->addClause('where', 'key', '=', "$value");
            }
        );

        $this->crud->addFilter(
            [
                'type'  => 'text',
                'name'  => 'complete_cpf',
                'label' => 'CPF Completo'
            ],
            false,
            function ($value) {
                $this->crud->addClause('where', 'complete_cpf', '=', "$value");
            }
        );

        $this->crud->addFilter([
            'name'  => 'type_entity',
            'type'  => 'dropdown',
            'label' => 'Tipo'
        ],
        DataMineEntitiesType::labels(),
        function($value) {
            $this->crud->addClause('where', 'type_entity', $value);
        });

        $this->crud->addFilter([
            'name'  => 'type_tax_regime',
            'type'  => 'dropdown',
            'label' => 'Regime Tributário'
        ],
        CompanyTaxRegime::labels(),
        function($value) {
            $this->crud->addClause('where', 'type_tax_regime', $value);
        });

        $this->crud->addFilter([
            'type'  => 'text',
            'name'  => 'code_ibge',
            'label' => 'Cód. IBGE'
        ],
        false,
        function ($value) {
            $this->crud->addClause('where', 'code_ibge', '=', "$value");
        }
        );
    }

    protected function setupShowOperation()
    {
        $this->setupListOperation();
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(DatamineEntityRequest::class);

        CRUD::field('key')->label('Chave Principal');
        CRUD::field('complete_cpf')->label('CPF Completo');
        CRUD::addField([
            'name' => 'type_entity',
            'label' => 'Tipo',
            'type' => 'select_from_array',
            'options' => DataMineEntitiesType::labels(),
            'allows_null' => false,
        ]);
        CRUD::addField([
            'name' => 'type_tax_regime',
            'label' => 'Regime Tributário',
            'type' => 'select_from_array',
            'options' => CompanyTaxRegime::labels(),
            'allows_null' => false,
        ]);
        CRUD::field('code_ibge')->label('Código IBGE');
        CRUD::field('obs')->label('Observação');
        // CRUD::field('extra');
        // CRUD::field('address');
        // CRUD::field('created_at');
        // CRUD::field('updated_at');

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
}
