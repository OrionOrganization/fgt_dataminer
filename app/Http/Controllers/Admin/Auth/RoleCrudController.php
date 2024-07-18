<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Models\Role;
use App\Traits\Crud\ControlCrudAccess;
use Backpack\PermissionManager\app\Http\Controllers\RoleCrudController as BackpackRoleCrud;

class RoleCrudController extends BackpackRoleCrud
{
    use ControlCrudAccess;


    protected const SYSTEM_ROLE_MESSAGES = [
        'super_admin' => 'Este grupo possui todas as permissões',
    ];
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        parent::setup();
    }

    public function setupListOperation()
    {
        parent::setupListOperation();

        $this->crud->modifyColumn('name', [
            'name' => 'translated_name',
            'orderable'  => false,
        ]);

        $this->crud->modifyColumn('permissions', [
            'attribute' => 'translated_name',
        ]);

    }

    public function setupCreateOperation()
    {
        parent::setupCreateOperation();

        $this->modifyFields();
    }

    public function setupUpdateOperation()
    {
        parent::setupUpdateOperation();

        $this->modifyFields();

        $this->modifyUpdateFieldsForSystemRoles();
    }

    protected function modifyFields(): void
    {
        $this->crud->modifyField('permissions', [
            'attribute' => 'translated_name',
            'number_of_columns' => 1,
        ]);
    }

    protected function modifyUpdateFieldsForSystemRoles(): void
    {
        $roleName = $this->crud->getCurrentEntry()->name;
        $roleMessage = self::SYSTEM_ROLE_MESSAGES[$roleName] ?? null;
        if (!$roleMessage) return;

        $this->crud->modifyField('name', [
            'name' => 'translated_name',
            'attributes' => [
                'disabled' => 'disabled',
            ],
        ]);

        $this->crud->modifyField('permissions', [
            'type' => 'custom_html',
            'value' => "<span>{$roleMessage}<span>",
        ]);
    }
}
