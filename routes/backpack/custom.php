<?php

use App\Http\Controllers\Admin\CompanyCrudController;
use App\Http\Controllers\Admin\ContactCrudController;
use App\Http\Controllers\Admin\LeadCrudController;
use App\Http\Controllers\Admin\OportunityCrudController;
use App\Http\Controllers\Admin\TaskCrudController;
use App\Http\Controllers\Datamine\DatamineDividaAbertaRawCrudController;
use App\Http\Controllers\Datamine\DatamineEntityCrudController;
use App\Http\Controllers\Datamine\DatamineEntityValueCrudController;
use App\Http\Controllers\Datamine\ImportFileController;
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
    Route::crud('product', 'ProductCrudController');
    Route::crud('blog-post', 'BlogPostCrudController');

    // CONTACT
    Route::crud('contact', 'ContactCrudController');
    Route::get('contact/ajax-contact-options', [ContactCrudController::class, 'contactOptions']);

    // COMPANY
    Route::crud('company', 'CompanyCrudController');
    Route::get('company/ajax-company-options', [CompanyCrudController::class, 'companyOptions']);

    // LEAD
    Route::crud('lead', 'LeadCrudController');
    Route::post('/lead/{model}/convert', [LeadCrudController::class, 'leadConvert'])->name('lead-convert');

    // OPORTUNITY
    Route::crud('oportunity', 'OportunityCrudController');
    Route::post('oportunity/ajax-oportunity-options', [OportunityCrudController::class, 'oportunityOptions']);
    Route::post('/oportunity/{model}/update-status', [OportunityCrudController::class, 'updateOportunityStatus'])->name('oportunity-update-status');

    // TASK
    Route::crud('task', 'TaskCrudController');
    Route::post('/task/{model}/update-status', [TaskCrudController::class, 'updateTaskStatus'])->name('task-update-status');
    Route::post('/task/create/by-oportunity/{model}', [TaskCrudController::class, 'createTaskByOportunity'])->name('create-task-by-oportunity');
    // Route::crud('datamine-divida-averta-raw', 'DatamineDividaAvertaRawCrudController');
}); // this should be the absolute last line of this file
Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin') . '/datamine',
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
], function () { // custom admin routes

    Route::crud('/raw', DatamineDividaAbertaRawCrudController::class);
    Route::crud('entity', DatamineEntityCrudController::class);
    Route::post('entity/recalcule', [DatamineEntityCrudController::class, 'recalculeEntity'])->name('entity-recalcule');
    Route::post('entity/{model}oportunity/create', [DatamineEntityCrudController::class, 'createOportunity'])->name('entity-create-oportunity');
    Route::crud('entity-value', DatamineEntityValueCrudController::class);

    Route::get('file', [ImportFileController::class, 'index'])->name('datamine-file');
    Route::post('file/store', [ImportFileController::class, 'store'])->name('datamine-file-store');
});