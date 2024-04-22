<?php

namespace App\Http\Controllers\Datamine;

use App\Http\Requests\Datamine\DatamineDividaAbertaRawRequest;
use App\Http\Requests\Datamine\DatamineDividaAvertaRawRequest;
use App\Models\Datamine\DatamineDividaAbertaRaw;
use App\Traits\Crud\HandlesCrudFields;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class DatamineDividaAvertaRawCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class DatamineDividaAbertaRawCrudController extends CrudController
{
    use HandlesCrudFields;

    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    //use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    //use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    //use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(DatamineDividaAbertaRaw::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/datamine/raw');
        CRUD::setEntityNameStrings('datamine divida aberta raw', 'datamine divida aberta raws');
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
            'name' => 'cpf_cnpj',
            'Label' => 'cpf_cnpj',
            'type' => 'text'
        ]);
        CRUD::addColumn([
            'name' => 'tipo_pessoa',
            'Label' => 'tipo_pessoa',
            'type' => 'text'
        ]);
        CRUD::addColumn([
            'name' => 'tipo_devedor',
            'Label' => 'tipo_devedor',
            'type' => 'text'
        ]);
        CRUD::addColumn([
            'name' => 'nome_devedor',
            'Label' => 'nome_devedor',
            'type' => 'text'
        ]);
        CRUD::addColumn([
            'name' => 'uf_devedor',
            'Label' => 'uf_devedor',
            'type' => 'text'
        ]);
        CRUD::addColumn([
            'name' => 'unidade_responsavel',
            'Label' => 'unidade_responsavel',
            'type' => 'text'
        ]);
        /*
        CRUD::addColumn([
            'name' => 'entidade_responsavel',
            'Label' => 'entidade_responsavel',
            'type' => 'text'
        ]);
        CRUD::addColumn([
            'name' => 'unidade_inscricao',
            'Label' => 'unidade_inscricao',
            'type' => 'text'
        ]);
        */
        CRUD::addColumn([
            'name' => 'numero_inscricao',
            'Label' => 'numero_inscricao',
            'type' => 'text'
        ]);
        CRUD::addColumn([
            'name' => 'tipo_situacao_inscricao',
            'Label' => 'tipo_situacao_inscricao',
            'type' => 'text'
        ]);
        CRUD::addColumn([
            'name' => 'situacao_inscricao',
            'Label' => 'situacao_inscricao',
            'type' => 'text'
        ]);
        CRUD::addColumn([
            'name' => 'tipo_credito',
            'Label' => 'tipo_credito',
            'type' => 'text'
        ]);
        CRUD::addColumn([
            'name' => 'receita_principal',
            'Label' => 'receita_principal',
            'type' => 'text'
        ]);
        CRUD::addColumn([
            'name' => 'data_inscricao',
            'Label' => 'data_inscricao',
            'type' => 'text'
        ]);
        CRUD::addColumn([
            'name' => 'valor_consolidado',
            'label' => 'Valor',
            'type'     => 'closure',
            'function' => function ($entry) {
                return $this->money($entry->valor_consolidado);
            }
        ]);
        CRUD::addColumn([
            'name' => 'file_type',
            'Label' => 'file_type',
            'type' => 'text'
        ]);
        CRUD::addColumn([
            'name' => 'file_year',
            'Label' => 'file_year',
            'type' => 'text'
        ]);
        CRUD::addColumn([
            'name' => 'file_quarter',
            'Label' => 'file_quarter',
            'type' => 'text'
        ]);
        CRUD::addColumn([
            'name' => 'status',
            'Label' => 'status',
            'type' => 'text'
        ]);

        $this->crud->addFilter(
            [
                'type'  => 'text',
                'name'  => 'cpf_cnpj',
                'label' => 'cpf_cnpj'
            ],
            false,
            function ($value) { // if the filter is active
                $this->crud->addClause('where', 'cpf_cnpj', '=', "$value");
            }
        );

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
        CRUD::setValidation(DatamineDividaAbertaRawRequest::class);



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
