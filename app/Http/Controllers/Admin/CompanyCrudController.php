<?php

namespace App\Http\Controllers\Admin;

use App\Enum\CompanyCategory;
use App\Enum\CompanyOrigin;
use App\Enum\CompanySetor;
use App\Enum\Datamine\CompanyTaxRegime;
use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use App\Services\DocumentService;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;

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
        CRUD::addColumn([
            'name' => 'cnpj',
            'label' => 'CNPJ',
            'type' => 'closure',
            'function' => function($entry) {
                return DocumentService::formatCnpj($entry->cnpj);
            }
        ]);

        CRUD::addColumn([
            'name' => 'category',
            'label' => 'Categoria',
            'type' => 'closure',
            'function' => function($entry) {
                return ($entry->category) ? CompanyCategory::from($entry->category)->getLabel() : '';
            }
        ]);
        
        CRUD::column('description')->label('Descrição');

        CRUD::column('social_reason')->label('Razão Social');

        CRUD::addColumn([
            'name' => 'origin',
            'label' => 'Origem',
            'type' => 'closure',
            'function' => function($entry) {
                return ($entry->origin) ? CompanyOrigin::from($entry->origin)->getLabel() : '';
            }
        ]);

        CRUD::addColumn([
            'type' => 'relationship',
            'name' => 'user_id',
            'label' => 'Responsável',
            'attribute' => 'name',
            'entity' => 'responsible',
        ]);

        CRUD::addColumn([
            'name' => 'setor',
            'label' => 'Setor',
            'type' => 'closure',
            'function' => function($entry) {
                return ($entry->setor) ? CompanySetor::from($entry->setor)->getLabel() : '';
            }
        ]);

        CRUD::column('employees_quantity')->label('Funcionários');
        CRUD::column('cnae')->label('CNAE');

        CRUD::addColumn([
            'label'     => 'Produtos',
            'type'      => 'select_multiple',
            'name'      => 'products',
            'entity'    => 'products',
            'attribute' => 'resume',
            'model'     => 'App\Models\Product',
        ]);

        CRUD::column('email');
        CRUD::column('phone')->label('Telefone');
        CRUD::column('whatsapp');
        CRUD::column('site');
        CRUD::addColumn([
            'name' => 'address',
            'type' => 'closure',
            'label' => 'Endereço',
            'function' => function($entry) {
                $string = str_replace(['"', '[', ']'], '', $entry->address);
                return $string;
            }
        ]);
        CRUD::addColumn([
            'name' => 'tax_regime',
            'label' => 'Regime Tributário',
            'type' => 'closure',
            'function' => function($entry) {
                return ($entry->tax_regime) ? CompanyTaxRegime::from($entry->tax_regime)->getLabel() : '';
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
                'name'  => 'nickname',
                'label' => 'Nome'
            ], 
            false, 
            function($value) {
                $this->crud->addClause('where', 'nickname', 'LIKE', "%$value%");
            }
        );

        $this->crud->addFilter(
            [
                'type'  => 'text',
                'name'  => 'cnpj',
                'label' => 'CNPJ'
            ], 
            false, 
            function($value) {
                $this->crud->addClause('where', 'cnpj', 'LIKE', "%$value%");
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
        CRUD::setValidation(CompanyRequest::class);

        CRUD::field('nickname')->label('Nome');
        CRUD::field('description')->label('Descrição');
        CRUD::field('cnpj')->label('CNPJ');
        CRUD::field('social_reason')->label('Razão Social');
        CRUD::addField([
            'name' => 'category',
            'label' => "Categoria",
            'type' => 'select_from_array',
            'options' => CompanyCategory::labels(),
            'allows_null' => true,
        ]);
        CRUD::addField([
            'name' => 'origin',
            'label' => "Origem",
            'type' => 'select_from_array',
            'options' => CompanyOrigin::labels(),
            'allows_null' => true,
        ]);
        CRUD::addField([
            'type' => 'relationship',
            'name' => 'user_id',
            'label' => 'Responsável',
            'attribute' => 'name',
            'entity' => 'responsible',
        ]);
        CRUD::addField([
            'name' => 'setor',
            'label' => "Setor",
            'type' => 'select_from_array',
            'options' => CompanySetor::labels(),
            'allows_null' => true,
        ]);
        CRUD::addField([
            'name' => 'tax_regime',
            'label' => 'Regime Tributário',
            'type' => 'select_from_array',
            'options' => CompanyTaxRegime::labels()
        ]);
        CRUD::field('employees_quantity')->label('Funcionários');
        CRUD::field('cnae')->label('CNAE');
        CRUD::field('phone')->label('Telefone');
        CRUD::field('whatsapp');
        CRUD::field('email');
        CRUD::field('site');
        CRUD::addField([
            'label' => "Produtos",
            'type' => 'select2_multiple',
            'name' => 'products',
            'attribute' => 'resume'
        ]);
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

    public function companyOptions(Request $request) {
        $term = $request->input('term');
        $options = Company::where('nickname', 'like', '%'.$term.'%')->get()->pluck('nickname', 'id');
        return $options;
    }
}
