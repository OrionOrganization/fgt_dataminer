<?php

namespace App\Traits\Crud;

trait ControlCrudAccess
{
    /**
     * Deny all operations unless there is a logged-in user with the permission.
     *
     * @var string $permission
     * @var string $deletePermissionSuffix
     * @return void
     */
    protected function authorize(
        string $permission,
        string $deletePermissionSuffix = '_delete'
    ): void {
        $this->authorizeOperations([
            'list' => $permission,
            'show' => $permission,
            'create' => $permission,
            'update' => $permission,
            'delete' => $permission . $deletePermissionSuffix,
            'fetch' => $permission,
        ]);
    }

    /**
     * Allow or deny operations based on the permissions mapped in an array.
     *
     * @param array $operationMappings Map of operations to permissions
     * @return array List of operations allowed from the map
     */
    protected function authorizeOperations(array $operationMappings): array
    {
        /**
         * @var \App\Models\User
         */
        $user = backpack_user();

        $allowed = [];
        foreach ($operationMappings as $operation => $permission) {
            if ($user && $user->can($permission)) {
                $this->crud->allowAccess($operation);
                $allowed[] = $operation;
            } else {
                $this->crud->denyAccess($operation);
            }
        }

        return $allowed;
    }

    /**
     * Permission
     * Deny all operations unless there is a logged-in user with the permission.
     *
     * @var string $permission
     * @var string|null $permissionList
     * @var string|null $permissionShow
     * @var string|null $permissionCreate
     * @var string|null $permissionUpdate
     * @var string|null $permissionUpdate
     * @var string|null $permissionFetch
     *
     * @return void
     */
    protected function authorizeEspecific(
        string $permission,
        string $permissionList = null,
        string $permissionShow = null,
        string $permissionCreate = null,
        string $permissionUpdate = null,
        string $permissionDelete = null,
        string $permissionFetch = null
    ): void {
        $permission = array(
            'list' => $permissionList ?? $permission,
            'show' => $permissionShow ?? $permission,
            'create' => $permissionCreate ?? $permission,
            'update' => $permissionUpdate ?? $permission,
            'delete' => $permissionDelete ?? $permission,
            'fetch' => $permissionFetch ?? $permission
        );

        $this->authorizeOperations($permission);
    }
}
