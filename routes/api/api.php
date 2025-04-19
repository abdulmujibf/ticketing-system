<?php

use Illuminate\Support\Facades\Route;

Route::prefix('api')->group(function () {
  require __DIR__ . '/category.php';
  require __DIR__ . '/priority.php';
  require __DIR__ . '/status.php';
  require __DIR__ . '/satisfaction.php';
  require __DIR__ . '/ticket/ticket.php';
});
