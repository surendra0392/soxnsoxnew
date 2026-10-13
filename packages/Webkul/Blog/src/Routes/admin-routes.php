<?php

use Illuminate\Support\Facades\Route;
use Webkul\Blog\Http\Controllers\Admin\BlogController;

Route::group([
    'middleware' => ['web', 'admin'],
    'prefix' => config('app.admin_url').'/blogs',
], function () {
    Route::get('/', [BlogController::class, 'index'])->name('admin.blogs.index');
    Route::get('/create', [BlogController::class, 'create'])->name('admin.blogs.create');
    Route::post('/create', [BlogController::class, 'store'])->name('admin.blogs.store');
    Route::get('/edit/{id}', [BlogController::class, 'edit'])->name('admin.blogs.edit');
    Route::put('/edit/{id}', [BlogController::class, 'update'])->name('admin.blogs.update');
    Route::delete('/{id}', [BlogController::class, 'destroy'])->name('admin.blogs.destroy');
});
