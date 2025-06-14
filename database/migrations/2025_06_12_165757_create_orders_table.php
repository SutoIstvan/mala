<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('external_id')->index();
            $table->string('external_shop')->index();
            $table->string('key')->nullable();
            $table->timestamp('created_at_external')->nullable();
            $table->timestamp('updated_at_external')->nullable();
            $table->longText('body_xml')->nullable();
            $table->string('status')->nullable();
            $table->string('sync')->nullable();
            $table->string('main_shop_key')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
