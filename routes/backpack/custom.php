<?php

use App\Http\Controllers\Admin\LeadCrudController;
use App\Http\Controllers\Admin\OportunityCrudController;
use App\Http\Controllers\Admin\TaskCrudController;
use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('company', 'CompanyCrudController');
    Route::crud('product', 'ProductCrudController');
    Route::crud('contact', 'ContactCrudController');
    Route::crud('blog-post', 'BlogPostCrudController');

    // LEAD
    Route::crud('lead', 'LeadCrudController');
    Route::post('/lead/{model}/convert', [LeadCrudController::class, 'leadConvert'])->name('lead-convert');
    
    // OPORTUNITY
    Route::crud('oportunity', 'OportunityCrudController');
    Route::get('/oportunity/{model}/update-status', [OportunityCrudController::class, 'updateOportunityStatus'])->name('oportunity-update-status');
    
    // TASK
    Route::crud('task', 'TaskCrudController');
    Route::get('/task/{model}/update-status', [TaskCrudController::class, 'updateTaskStatus'])->name('task-update-status');
    Route::post('/task/create/by-oportunity/{model}', [TaskCrudController::class, 'createTaskByOportunity'])->name('create-task-by-oportunity');
}); // this should be the absolute last line of this file