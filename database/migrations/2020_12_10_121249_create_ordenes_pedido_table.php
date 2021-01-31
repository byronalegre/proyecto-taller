<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdenesPedidoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        Schema::create('ordenes_pedido', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('status');            
            $table->string('codigo')->unique();
            $table->string('responsable_id');
            $table->date('fecha_prog');
            $table->text('descripcion');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ordenespedido');
    }
}
