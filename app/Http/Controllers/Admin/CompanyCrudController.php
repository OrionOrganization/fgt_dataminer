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
        CRUD::setEntityNameStrings('company', 'companies');
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
        CRUD::column('nickname');
        CRUD::column('cnpj');
        CRUD::column('social_reason');
        CRUD::column('category');
        CRUD::column('origin');
        CRUD::column('user_id');
        CRUD::column('setor');
        CRUD::column('description');
        CRUD::column('phone');
        CRUD::column('whatsapp');
        CRUD::column('email');
        CRUD::column('site');
        CRUD::column('address');
        CRUD::column('created_at');
        CRUD::column('updated_at');

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

        CRUD::field('nickname');
        CRUD::field('cnpj');
        CRUD::field('social_reason');
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
        CRUD::field('description');
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
