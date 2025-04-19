<?php

use App\Http\Controllers\Options\StatusController;
use Illuminate\Support\Facades\Route;

Route::prefix('status')->name('status.')->group(function () {
  Route::get('get-by-slug', [StatusController::class, 'getBySlug'])->name('get-by-slug');
  Route::get('get-by-department', [StatusController::class, 'getByDepartment'])->name('get-by-department');
  Route::post('store', [StatusController::class, 'store'])->name('store');
  Route::put('update/{id}', [StatusController::class, 'update'])->name('update');
  Route::delete('delete/{id}', [StatusController::class, 'destroy'])->name('destroy');
});
