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
    Schema::create('it_tickets', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('user_id');
      $table->unsignedBigInteger('assignee_id')->nullable();
      $table->unsignedBigInteger('category_id')->nullable();
      $table->unsignedBigInteger('priority_id')->nullable();
      $table->unsignedBigInteger('status_id')->nullable();
      $table->unsignedBigInteger('department_id')->nullable();
      $table->string('title');
      $table->text('description');
      $table->json('attributes')->nullable();
      $table->dateTime('time_worked')->nullable();
      $table->unsignedBigInteger('time_spent')->default(0);
      $table->unsignedBigInteger('response_time')->default(0);
      $table->timestamps();

      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
      $table->foreign('assignee_id')->references('id')->on('users')->onDelete('cascade');
      $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
      $table->foreign('priority_id')->references('id')->on('priorities')->onDelete('cascade');
      $table->foreign('status_id')->references('id')->on('statuses')->onDelete('cascade');
      $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('it_tickets');
  }
};
