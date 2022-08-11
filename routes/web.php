<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
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

Route::controller(TaskController::class)->group(function () {
    Route::get('/', 'index')->name('tasks.index');
    Route::get('task/create', 'create')->name('task.create');
    Route::get('project/create', 'createProject')->name('project.create');
    Route::post('tasks/store', 'store')->name('task.store');
    Route::get('tasks/{id}', 'edit')->name('task.edit');
    Route::put('tasks/{id}', 'update')->name('task.update');
    Route::delete('/{id}', 'destroy')->name('task.destroy');
});

Route::controller(ProjectController::class)->group(function () {
    Route::get('project/create', 'create')->name('project.create');
    Route::post('project/store', 'store')->name('project.store');
});
