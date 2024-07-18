<?php

use App\Http\Controllers\Web\BlogPostController;
use App\Http\Controllers\Web\LeadController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('landing_page');
});

Route::get('/servicos', function () {
    return view('services');
});

Route::get('/blog', [BlogPostController::class, 'index']);
Route::get('/blog/{model}', [BlogPostController::class, 'show']);

Route::post('/lead', [LeadController::class, 'store']);
