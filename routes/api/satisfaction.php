<?php

use App\Http\Controllers\Options\SatisfactionController;
use Illuminate\Support\Facades\Route;

Route::prefix('satisfaction')->name('satisfaction.')->group(function () {
  Route::get('get-by-portal', [SatisfactionController::class, 'getByPortal'])->name('get-by-portal');
  Route::post('store', [SatisfactionController::class, 'store'])->name('store');
  Route::put('update/{id}', [SatisfactionController::class, 'update'])->name('update');
  Route::delete('delete/{id}', [SatisfactionController::class, 'destroy'])->name('destroy');
});
