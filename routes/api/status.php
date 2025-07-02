<?php

use App\Http\Controllers\Options\StatusController;
use Illuminate\Support\Facades\Route;

Route::prefix('status')->name('status.')->group(function () {
  Route::get('get-by-slug', [StatusController::class, 'getBySlug'])->name('get-by-slug');
  Route::get('get-by-portal', [StatusController::class, 'getByPortal'])->name('get-by-portal');
  Route::post('store', [StatusController::class, 'store'])->name('store');
  Route::put('update/{id}', [StatusController::class, 'update'])->name('update');
  Route::delete('delete/{id}', [StatusController::class, 'destroy'])->name('destroy');
});
