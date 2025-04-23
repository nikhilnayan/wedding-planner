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
        Schema::create('gift_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gift_registry_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->string('image_url')->nullable();
            $table->string('product_url')->nullable();
            $table->integer('quantity_desired')->default(1);
            $table->integer('quantity_received')->default(0);
            $table->boolean('is_purchased')->default(false);
            $table->string('purchased_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gift_items');
    }
};
