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
        Schema::create('child_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_product_id')->constrained('products')->onDelete('cascade');
            $table->string('sku')->unique();
            $table->string('unas_id')->unique();
            $table->string('shopify_id')->nullable();
            $table->string('state')->nullable();
            $table->string('name')->nullable();
            $table->string('price')->nullable();
            $table->string('unit')->nullable();
            $table->string('url')->nullable();
            $table->string('qty')->nullable();
            $table->text('category')->nullable();
            $table->text('description')->nullable();
            $table->text('images')->nullable();
            $table->text('params')->nullable();
            $table->text('variants')->nullable();
            $table->text('statuses')->nullable();
            $table->text('history')->nullable();
            $table->text('types')->nullable();
            $table->text('datas')->nullable();
            $table->timestamp('create_time')->nullable();
            $table->timestamp('last_mod_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('child_products');
    }
};
