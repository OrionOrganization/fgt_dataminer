<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Models\Role;
use App\Traits\Crud\ControlCrudAccess;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

use Backpack\PermissionManager\app\Http\Controllers\UserCrudController as BackpackUserCrud;

/**
 * Class UserCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UserCrudController extends BackpackUserCrud
{
    use ControlCrudAccess;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::enableExportButtons();

        parent::setup();
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    public function setupListOperation()
    {
        //parent::setupListOperation();

        CRUD::addColumn([
            'type' => 'text',
            'name' => 'name',
            'label' => __('Nome'),
        ]);
        CRUD::addColumn([
            'type' => 'text',
            'name' => 'email',
            'label' => __('Email'),
        ]);

        CRUD::addColumn([
            'type' => 'relationship',
            'name' => 'roles',
            'label' => trans('backpack::permissionmanager.roles'),
        ]);
        CRUD::addColumn([
            'type' => 'relationship',
            'name' => 'permissions',
            'label' => ucfirst(trans('backpack::permissionmanager.permission_singular')),
        ]);


        $this->crud->modifyColumn('roles', [
            'attribute' => 'translated_name',
        ]);

        $this->crud->modifyColumn('permissions', [
            'attribute' => 'translated_name',
        ]);

        CRUD::addColumn([
            'type' => 'boolean',
            'name' => 'blocked',
            'label' => __('Usuário Bloqueado'),
        ]);

        $this->crud->addFilter([
            'name'  => 'blocked',
            'type'  => 'select2',
            'label' => 'Bloqueado'
        ], function () {
            return [
                0 => ucfirst(trans('backpack::crud.no')),
                1 => ucfirst(trans('backpack::crud.yes')),
            ];
        }, function ($value) {
            $this->crud->addClause('where', 'blocked', $value);
        });

        $groups = Role::all()->pluck('translated_name', 'id')->toArray();

        $this->crud->addFilter([
            'type'  => 'select2_multiple',
            'name' => 'roles',
            'label' => trans('backpack::permissionmanager.roles')
        ], $groups, function ($values) { // if the filter is active
            $this->crud->addClause('whereHas', 'roles', function ($q) use ($values) {
                $q->whereIn('id', json_decode($values));
            });
        });
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    public function setupCreateOperation()
    {
        parent::setupCreateOperation();

        $this->addCustomFields();

        $this->modifyFields();
        //activity()->log('Look mum 2 , I logged something3');
        /*
        $user = backpack_user();
        $row = Role::find(1);

        activity()
        ->causedBy($user)
        ->performedOn($row)
        ->log('edited');
        */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    public function setupUpdateOperation()
    {
        parent::setupUpdateOperation();

        $this->addCustomFields();

        $this->modifyFields();
    }

    protected function addCustomFields(): void
    {
        $this->crud->addField([
            'type' => 'checkbox',
            'name' => 'blocked',
            'label' => __('Usuário Bloqueado'),
        ])->afterField('email');
    }

    protected function modifyFields(): void
    {

        $this->crud->modifyField(['roles', 'permissions'], [
            'subfields' => [
                'primary' => [
                    'label' => trans('backpack::permissionmanager.roles'),
                    'name' => 'roles',
                    'entity' => 'roles',
                    'entity_secondary' => 'permissions',
                    'attribute' => 'translated_name',
                    'model' => config('permission.models.role'),
                    'pivot' => true,
                    'number_columns' => 3,
                ],
                'secondary' => [
                    'label' => ucfirst(trans('backpack::permissionmanager.permission_singular')),
                    'name' => 'permissions',
                    'entity' => 'permissions',
                    'entity_primary' => 'roles',
                    'attribute' => 'translated_name',
                    'model' => config('permission.models.permission'),
                    'pivot' => true,
                    'number_columns' => 3,
                ],
            ],
        ]);
    }
}
