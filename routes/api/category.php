<?php

use App\Http\Controllers\Options\CategoryController;
use Illuminate\Support\Facades\Route;

Route::prefix('category')->name('category.')->group(function () {
  Route::get('get-by-slug', [CategoryController::class, 'getBySlug'])->name('get-by-slug');
  Route::get('get-by-portal', [CategoryController::class, 'getByPortal'])->name('get-by-portal');
  Route::post('store', [CategoryController::class, 'store'])->name('store');
  Route::put('update/{id}', [CategoryController::class, 'update'])->name('update');
  Route::delete('delete/{id}', [CategoryController::class, 'destroy'])->name('destroy');
});
