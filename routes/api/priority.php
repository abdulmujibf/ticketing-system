<?php

use App\Http\Controllers\Options\PriorityController;
use Illuminate\Support\Facades\Route;

Route::prefix('priority')->name('priority.')->group(function () {
  Route::get('get-by-slug', [PriorityController::class, 'getBySlug'])->name('get-by-slug');
  Route::get('get-by-portal', [PriorityController::class, 'getByPortal'])->name('get-by-portal');
  Route::post('store', [PriorityController::class, 'store'])->name('store');
  Route::put('update/{id}', [PriorityController::class, 'update'])->name('update');
  Route::delete('delete/{id}', [PriorityController::class, 'destroy'])->name('destroy');
});
