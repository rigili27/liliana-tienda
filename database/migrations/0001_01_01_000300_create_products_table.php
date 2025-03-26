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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->longText('description')->nullable();
            $table->longText('tags')->nullable();
            $table->json('image_url')->nullable();
            $table->integer('stock')->nullable();
            $table->decimal('off_price', 15, 2)->nullable();
            $table->decimal('off_porcent', 15, 2)->nullable();
            $table->decimal('dolar_price', 15, 2)->nullable();
            $table->decimal('price_1', 15, 2)->nullable();
            $table->decimal('price_2', 15, 2)->nullable();
            $table->decimal('price_3', 15, 2)->nullable();
            $table->decimal('price_m_1', 15, 2)->nullable();
            $table->decimal('price_m_2', 15, 2)->nullable();
            $table->decimal('price_m_3', 15, 2)->nullable();
            $table->boolean('is_off')->default(0);
            $table->boolean('is_new')->default(0);
            $table->boolean('active')->default(1);
            $table->string('sku')->nullable();
            $table->string('bar_code')->nullable();
            $table->integer('position')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('products');
    }
};
