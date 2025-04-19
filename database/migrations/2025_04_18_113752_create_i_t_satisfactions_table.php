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
    Schema::create('it_satisfactions', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('user_id');
      $table->unsignedBigInteger('ticket_id');
      $table->unsignedBigInteger('satisfaction_id');
      $table->json('answers');
      $table->text('feedback')->nullable();
      $table->timestamps();

      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
      $table->foreign('ticket_id')->references('id')->on('it_tickets')->onDelete('cascade');
      $table->foreign('satisfaction_id')->references('id')->on('satisfactions')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('it_satisfactions');
  }
};
