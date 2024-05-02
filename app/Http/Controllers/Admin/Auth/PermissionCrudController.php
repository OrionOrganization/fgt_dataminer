<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Traits\Crud\ControlCrudAccess;
use Backpack\PermissionManager\app\Http\Controllers\PermissionCrudController as BackpackPermissionCrud;

class PermissionCrudController extends BackpackPermissionCrud
{
    use ControlCrudAccess;

    public function setup()
    {
        parent::setup();
    }

    public function setupListOperation()
    {
        $this->crud->addColumn([
            'type' => 'text',
            'name' => 'id',
            'label' => __('ID'),
        ]);

        parent::setupListOperation();

        $this->crud->modifyColumn('name', [
            'name' => 'translated_name',
            'orderable' => false,
        ]);
    }
}
