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
        Schema::create('order_items', function (Blueprint $table) {
            
            // migracion anterior
            // $table->id();
            // $table->foreignId('order_id')->nullable()->constrained()->cascadeOnDelete();
            // $table->foreignId('product_id')->nullable()->constrained()->cascadeOnDelete();
            // $table->string('description')->nullable();
            // $table->integer('quantity')->nullable();
            // $table->decimal('unit_price', 20, 2)->nullable();
            // $table->decimal('alicuota', 20, 2)->nullable();
            // $table->decimal('importe', 20, 2)->nullable();
            // $table->timestamps();
            //

            $table->id();
            $table->string('entsal', 1)->nullable();
            $table->integer('estado')->nullable();
            // clavemov
            $table->foreignId('order_id')->nullable()->constrained()->cascadeOnDelete();
            $table->integer('clavecompras')->nullable();
            $table->integer('claveess')->nullable();
            $table->integer('clavemed')->nullable();
            $table->integer('claverep')->nullable();
            $table->integer('coddeposito')->nullable();
            $table->string('codarticulo')->nullable();
            $table->string('descarticulo')->nullable();
            $table->decimal('precioarticulo', 10, 2)->nullable();
            $table->decimal('cantidad', 10, 3)->nullable();
            $table->decimal('importe', 10, 2)->nullable();
            $table->decimal('poriva', 5, 2)->nullable();
            $table->string('porivani')->nullable();
            $table->text('comentario')->nullable();
            $table->string('fecha')->nullable();
            $table->decimal('preciocosto', 10, 2)->nullable();
            $table->integer('muevestock')->nullable();
            $table->integer('genfactura')->nullable();
            $table->integer('marcagfa')->nullable();
            $table->integer('gfaidfactura')->nullable();
            $table->integer('vtaanticipada')->nullable();
            $table->decimal('cantidadvta', 10, 2)->nullable();
            $table->string('nrocompimp')->nullable();
            $table->integer('codcliente')->nullable();
            $table->integer('marcaanulado')->nullable();
            $table->integer('reserva')->nullable();
            $table->integer('idclavepropia')->nullable();
            $table->integer('propiedad')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('order_items');
    }
};
