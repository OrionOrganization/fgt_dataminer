<?php

namespace App\Providers;

use App\Http\Controllers\Admin\AdminController as AdminAdminController;
use App\Http\Controllers\Admin\Auth\PermissionCrudController as AuthPermissionCrudController;
use App\Http\Controllers\Admin\Auth\RoleCrudController as AuthRoleCrudController;
use App\Http\Controllers\Admin\Auth\UserCrudController as AuthUserCrudController;
use Backpack\CRUD\app\Http\Controllers\AdminController;
use Backpack\PermissionManager\app\Http\Controllers\PermissionCrudController;
use Backpack\PermissionManager\app\Http\Controllers\RoleCrudController;
use Backpack\PermissionManager\app\Http\Controllers\UserCrudController;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PermissionCrudController::class, AuthPermissionCrudController::class);
        $this->app->bind(RoleCrudController::class, AuthRoleCrudController::class);
        $this->app->bind(UserCrudController::class, AuthUserCrudController::class);
        $this->app->bind(AdminController::class, AdminAdminController::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
