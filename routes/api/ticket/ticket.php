<?php

use App\Http\Controllers\Ticket\ITTicketController;
use Illuminate\Support\Facades\Route;

Route::prefix('ticket')->name('ticket.')->group(function () {
  Route::get('get', [ITTicketController::class, 'get'])->name('get');
  Route::get('get-by-id/{id}', [ITTicketController::class, 'getById'])->name('get-by-id');
  Route::post('store', [ITTicketController::class, 'store'])->name('store');
  Route::put('update/{id}', [ITTicketController::class, 'update'])->name('update');
  Route::delete('delete/{id}', [ITTicketController::class, 'destroy'])->name('destroy');
});
