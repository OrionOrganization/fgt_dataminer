<?php

namespace App\Http\Controllers\Admin;

use App\Enum\CompanyCategory;
use App\Enum\CompanyOrigin;
use App\Enum\CompanySetor;
use App\Http\Requests\CompanyRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CompanyCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CompanyCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Company::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/company');
        CRUD::setEntityNameStrings('empresa', 'empresas');
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
        CRUD::column('nickname')->label('Nome');
        CRUD::column('cnpj')->label('CNPJ');
        CRUD::column('social_reason')->label('Razão Social');
        CRUD::addColumn([
            'name' => 'category',
            'label' => 'Categoria',
            'type' => 'closure',
            'function' => function($entry) {
                return CompanyCategory::from($entry->category)->getLabel();
            }
        ]);
        CRUD::addColumn([
            'name' => 'origin',
            'label' => 'Origem',
            'type' => 'closure',
            'function' => function($entry) {
                return CompanyOrigin::from($entry->origin)->getLabel();
            }
        ]);
        CRUD::column('user_id')->label('Responsável');
        CRUD::addColumn([
            'name' => 'setor',
            'label' => 'Setor',
            'type' => 'closure',
            'function' => function($entry) {
                return CompanySetor::from($entry->setor)->getLabel();
            }
        ]);
        CRUD::column('description')->label('Descrição');
        CRUD::column('phone')->label('Telefone');
        CRUD::column('whatsapp');
        CRUD::column('email');
        CRUD::column('site');
        CRUD::column('address');
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
        CRUD::setValidation(CompanyRequest::class);

        CRUD::field('nickname')->label('Nome');
        CRUD::field('cnpj')->label('CNPJ');
        CRUD::field('social_reason')->label('Razão Social');
        CRUD::addField([
            'name'        => 'category',
            'label'       => "Categoria",
            'type'        => 'select_from_array',
            'options'     => CompanyCategory::labels(),
            'allows_null' => false,
        ]);
        CRUD::addField([
            'name'        => 'origin',
            'label'       => "Origem",
            'type'        => 'select_from_array',
            'options'     => CompanyOrigin::labels(),
            'allows_null' => false,
        ]);
        CRUD::field('user_id');
        CRUD::addField([
            'name'        => 'setor',
            'label'       => "Setor",
            'type'        => 'select_from_array',
            'options'     => CompanySetor::labels(),
            'allows_null' => false,
        ]);
        CRUD::field('description')->label('Descrição');
        CRUD::field('phone');
        CRUD::field('whatsapp');
        CRUD::field('email');
        CRUD::field('site');
        CRUD::field('address');

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
