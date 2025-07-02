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
    Schema::create('portal_fields', function (Blueprint $table) {
      $table->id();
      $table->foreignId('portal_id')->constrained()->onDelete('cascade');
      $table->string('label');
      $table->string('name');
      $table->string('type');
      $table->string('default_value')->nullable();
      $table->json('options')->nullable();
      $table->boolean('is_required')->default(false);
      $table->string('placeholder')->nullable();
      $table->text('help_text')->nullable();
      $table->integer('order')->default(0);
      $table->json('visibility_condition');
      $table->timestamps();

      $table->unique(['portal_id', 'name']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('portal_fields');
  }
};
