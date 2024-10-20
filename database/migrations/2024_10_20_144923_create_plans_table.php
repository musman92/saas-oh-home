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
    Schema::create('plans', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->onDelete('cascade');
      $table->enum ('level', ['sub_admin', 'sub_user'])->default('sub_admin')->comment('sub_admin are plans for sub admin, sub_user are plans for sub user');
      $table->string('name');
      $table->integer('amount');
      $table->string('interval');
      $table->integer('interval_count');
      $table->string('description')->nullable();
      $table->string('stripe_plan_id');
      $table->text('stripe_plan');
      $table->string('stripe_product_id');
      $table->text('stripe_product');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('plans');
  }
};
