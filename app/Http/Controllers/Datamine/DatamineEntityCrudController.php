<?php

namespace App\Http\Controllers\Datamine;

use App\Enum\AddressState;
use App\Enum\Datamine\CompanyTaxRegime;
use App\Enum\Datamine\DataMineEntitiesType;
use App\Http\Requests\DatamineEntityRequest;
use App\Models\Datamine\DatamineEntity;
use App\Services\Datamine\DataMineService;
use App\Services\OportunityService;
use App\Traits\Crud\HandlesCrudFields;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class DatamineEntityCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class DatamineEntityCrudController extends CrudController
{
    use HandlesCrudFields;

    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;

    /**
     * @var \App\Services\Datamine\DataMineService
     */
    protected $datamineService;

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
        CRUD::setModel(\App\Models\Datamine\DatamineEntity::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/datamine/entity');
        CRUD::setEntityNameStrings('entidade', 'entidades');

        $this->crud->addButtonFromView('line', 'create_oportunity', 'create_oportunity', 'beginning');
        $this->crud->addButtonFromView('line', 'recalcule_values', 'recalcule_values', 'beginning');
        $this->crud->addButtonFromView('top', 'recalcule_values_top', 'recalcule_values_top', 'beginning');

        $this->datamineService = resolve(DataMineService::class);
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
        CRUD::addColumn([
            'name' => 'key',
            'label' => 'Chave',
        ]);

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
            'label' => 'Benefício Fiscal',
            'type' => 'closure',
            'function' => function($entry) {
                return $this->money($entry->value->value_type_tax_benefit);
            }
        ]);

        CRUD::addColumn([
            'name' => 'value_type_in_collection',
            'label' => 'Em Cobrança',
            'type' => 'closure',
            'function' => function($entry) {
                return $this->money($entry->value->value_type_in_collection);
            }
        ]);

        CRUD::addColumn([
            'name' => 'value_type_in_negociation',
            'label' => 'Em Negociação',
            'type' => 'closure',
            'function' => function($entry) {
                return $this->money($entry->value->value_type_in_negociation);
            }
        ]);

        CRUD::addColumn([
            'name' => 'value_type_guarantee',
            'label' => 'Garantia',
            'type' => 'closure',
            'function' => function($entry) {
                return $this->money($entry->value->value_type_guarantee);
            }
        ]);

        CRUD::addColumn([
            'name' => 'value_type_suspended',
            'label' => 'Suspenso',
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

        $this->setupFilters();
    }

    protected function setupFilters()
    {
        CRUD::addFilter(
            [
                'type'  => 'text',
                'name'  => 'key',
                'label' => 'Chave'
            ],
            false,
            function ($value) {
                $this->crud->addClause('where', 'key', '=', "$value");
            }
        );

        CRUD::addFilter(
            [
                'name'  => 'type_entity',
                'type'  => 'dropdown',
                'label' => 'Tipo'
            ],
            DataMineEntitiesType::labels(),
            function($value) {
                $this->crud->addClause('where', 'type_entity', $value);
            }
        );

        CRUD::addFilter(
            [
                'name'  => 'type_tax_regime',
                'type'  => 'dropdown',
                'label' => 'Regime Tributário'
            ],
            CompanyTaxRegime::labels(),
            function($value) {
                $this->crud->addClause('where', 'type_tax_regime', $value);
            }
        );

        CRUD::addFilter(
            [
                'type'  => 'text',
                'name'  => 'code_ibge',
                'label' => 'Cód. IBGE'
            ],
            false,
            function ($value) {
                $this->crud->addClause('where', 'code_ibge', '=', "$value");
            }
        );

        CRUD::addFilter(
            [
                'type' => 'select2',
                'name' => 'ibge_state',
                'label' => __('Estado IBGE'),
            ],
            AddressState::toArray(),
            function ($value) {
                $value = '%' . $value . '%';
                $callback = function ($query) use ($value) {
                    $query->where('uf_sigla', 'like', '%' . $value . '%');
                };

                $this->crud->addClause('where', function ($query) use ($callback) {
                    $query->whereHas('ibge', $callback);
                });
            }
        );


        CRUD::addFilter(
            [
                'type' => 'text',
                'name' => 'ibge_city',
                'label' => __('Município IBGE'),
            ],
            AddressState::toArray(),
            function ($value) {
                $value = '%' . $value . '%';
                $callback = function ($query) use ($value) {
                    $query->where('municipio', 'like', '%' . $value . '%');
                };

                $this->crud->addClause('where', function ($query) use ($callback) {
                    $query->whereHas('ibge', $callback);
                });
            }
        );

        $valuesArray = [
            'value_all' => 'Valor Total',
            'value_indicador_ajuizado' => 'Valor Ajuizado',
            'value_n_indicador_ajuizado' => 'Valor Não Ajuizado',
            'value_type_tax_benefit' => 'Valor Benefício Fiscal',
            'value_type_in_collection' => 'Valor Em Cobrança',
            'value_type_in_negociation' => 'Valor Em Negociação',
            'value_type_guarantee' => 'Valor Garantia',
            'value_type_suspended' => 'Valor Suspenso',
            'value_type_others' => 'Valor Outros'
        ];

        foreach($valuesArray as $name => $valueLabel) {
            CRUD::addFilter([
                'type' => 'money_range',
                'name' => $name,
                'label' => $valueLabel,
                'label_from' => 'Min',
                'label_to' => 'Max'
            ], false, function($value) use ($name) {
                $this->filterMoneyRange($value, $name);
            });
        }
    }

    protected function filterMoneyRange($value, $valueType)
    {
        $range = json_decode($value);
        if ($range->from) {
            $from = $this->convertStringMoneyToInt($range->from) ?? 0;

            $callback = function ($query) use ($from, $valueType) {
                $query->where($valueType, '>=', $from);
            };

            $this->crud->addClause('where', function ($query) use ($callback) {
                $query->whereHas('value', $callback);
            });
        }
        if ($range->to) {
            $to = $this->convertStringMoneyToInt($range->to) ?? 0;

            $callback = function ($query) use ($to, $valueType) {
                $query->where($valueType, '<=', $to);
            };

            $this->crud->addClause('where', function ($query) use ($callback) {
                $query->whereHas('value', $callback);
            });
        }
    }

    protected function setupShowOperation()
    {
        CRUD::column('id');
        CRUD::addColumn([
            'name' => 'key',
            'label' => 'Chave',
        ]);
        CRUD::column('key_unmask')->label('Dígitos Chave');

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

        CRUD::addColumn([
            'name'  => 'values_details',
            'label' => 'Valores',
            'type'  => 'view',
            'view'  => backpack_view('base.datamine.datamine_details_values'),
        ]);

        CRUD::column('code_ibge')->label('Cód. IBGE');

        CRUD::addColumn([
            'name' => 'address',
            'type' => 'closure',
            'label' => 'Endereço',
            'function' => function($entry) {
                $string = str_replace(['"', '[', ']'], '', $entry->address);
                return $string;
            }
        ]);

        // CRUD::addColumn([
        //     'name'  => 'value',
        //     'label' => 'Valores',
        //     'type'  => 'view',
        //     'view'  => backpack_view('base.datamine.values_table'),
        // ]);

        // CRUD::addColumn([
        //     'name'  => 'raws',
        //     'label' => 'Dívdas Abertas',
        //     'type'  => 'view',
        //     'view'  => backpack_view('base.datamine.dividas_raws_table'),
        // ]);

        CRUD::column('obs')->label('Observações');
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

        CRUD::field('key')->label('Chave');
        CRUD::field('key_unmask')->label('Dígitos Chave');
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
        CRUD::field('key_unmask')->label('Dígitos Chave');

        CRUD::addField([
            'name' => 'type_tax_regime',
            'label' => 'Regime Tributário',
            'type' => 'select_from_array',
            'options' => CompanyTaxRegime::labels(),
            'allows_null' => false,
        ]);

        CRUD::field('obs')->label('Observações');
    }

    /**
     * @param Request $request
     * 
     * @return JsonResponse
     */
    public function recalculeEntity(Request $request): JsonResponse
    {
        try {
            $key = $request->input('key');
            $this->datamineService->analyzeDatamineRaws($key);

            return response()->json(['success' => true]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Falha ao recalcular, motivo: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * @param DatamineEntity $model
     * 
     * @return JsonResponse
     */
    public function createOportunity(DatamineEntity $model): JsonResponse
    {
        try {
            $company = $this->datamineService->createCompanyByEntity($model);

            $this->oportunityService->createNewOportunity($company);

            return response()->json(['success' => true]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Falha ao criar oportunidade, motivo: ' . $e->getMessage()
            ]);
        }
    }
}
