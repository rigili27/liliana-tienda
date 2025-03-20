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
        Schema::create('orders', function (Blueprint $table) {

            // migracion anterior
            // $table->id();
            // $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            // $table->string('prefix')->nullable();
            // $table->string('number')->nullable();
            // $table->string('letter')->nullable();
            // $table->string('type_mov')->nullable();
            // $table->date('date');
            // $table->string('user_name')->nullable();
            // $table->string('user_address')->nullable();
            // $table->string('user_cuit')->nullable();
            // $table->string('cond_iva')->nullable();
            // $table->string('cond_venta')->nullable();
            // $table->decimal('neto_1', 20, 2)->nullable();
            // $table->decimal('alicuota_1', 20, 2)->nullable();
            // $table->decimal('imp_iva_1', 20, 2)->nullable();
            // $table->decimal('neto_2', 20, 2)->nullable();
            // $table->decimal('alicuota_2', 20, 2)->nullable();
            // $table->decimal('imp_iva_2', 20, 2)->nullable();
            // $table->decimal('neto_3', 20, 2)->nullable();
            // $table->decimal('alicuota_3', 20, 2)->nullable();
            // $table->decimal('imp_iva_3', 20, 2)->nullable();
            // $table->decimal('imp_interno', 20, 2)->nullable();
            // $table->decimal('imp_dto', 20, 2)->nullable();
            // $table->decimal('precepciones', 20, 2)->nullable();
            // $table->decimal('total', 20, 2)->nullable();
            // $table->string('cae')->nullable();
            // $table->date('date_vto_cae')->nullable();
            // $table->boolean('mov_sart')->default(0);
            // $table->string('estable')->nullable();
            // $table->timestamps();
            // 

            $table->id();
            $table->string('fecha')->nullable();
            $table->string('fechavto')->nullable();
            $table->string('tipomov')->nullable();
            $table->string('talonario')->nullable();
            $table->string('nrocomprobante')->nullable();
            $table->string('codadminis')->nullable();
            $table->string('condvta')->nullable();
            // $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('user_id')->nullable();
            $table->string('nombre')->nullable();
            $table->string('nrocuit')->nullable();
            $table->string('codcativa')->nullable();
            $table->string('domicilio')->nullable();
            $table->string('codlocalidad')->nullable();
            $table->string('tipoprecios')->nullable();
            $table->string('nrolispre')->nullable();
            $table->string('neto1')->nullable();
            $table->string('poriva1')->nullable();
            $table->string('impiva1')->nullable();
            $table->string('neto2')->nullable();
            $table->string('poriva2')->nullable();
            $table->string('impiva2')->nullable();
            $table->string('neto3')->nullable();
            $table->string('poriva3')->nullable();
            $table->string('impiva3')->nullable();
            $table->string('impiinterno')->nullable();
            $table->string('retganancias')->nullable();
            $table->string('retiva')->nullable();
            $table->string('retibruto')->nullable();
            $table->string('percepciones')->nullable();
            $table->string('sellado')->nullable();
            $table->string('totalgral')->nullable();
            $table->string('totchqcar')->nullable();
            $table->string('totefectivo')->nullable();
            $table->string('tottransferencia')->nullable();
            $table->string('totcanje')->nullable();
            $table->string('marcacont')->nullable();
            $table->string('marcaestado')->nullable();
            $table->string('ventaanticipada')->nullable();
            $table->text('nota')->nullable();
            $table->string('cotizdolar')->nullable();
            $table->string('novaaliva')->nullable();
            $table->text('notamovimiento')->nullable();
            $table->string('marcafcanje')->nullable();
            $table->string('idivacanje')->nullable();
            $table->string('numerorto')->nullable();
            $table->string('coddeposito')->nullable();
            $table->string('dolar')->nullable();
            $table->string('marcaanulado')->nullable();
            $table->string('nrocae')->nullable();
            $table->string('fechacae')->nullable();
            $table->string('letrafactura')->nullable();
            $table->string('idCobranza')->nullable();
            $table->string('imagen')->nullable();
            $table->string('movsart')->nullable();
            $table->string('marcarval')->nullable();
            $table->string('idrecvalores')->nullable();
            $table->longText('attach')->nullable();
            $table->timestamps();

            $table->index('nrocuit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('orders');
    }
};
