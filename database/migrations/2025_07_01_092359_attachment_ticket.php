<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('attachment_tickets', function (Blueprint $table) {
      $table->foreignId('ticket_id');
      $table->foreignId('attachment_id');
      $table->string('department');
      $table->string('file_name')->nullable();
      $table->string('file_size')->nullable();
      $table->string('file_type')->nullable();
      $table->string('file_location')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('attachment_tickets');
  }
};
