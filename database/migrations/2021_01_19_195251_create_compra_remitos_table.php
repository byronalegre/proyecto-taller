<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompraRemitosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compra_remitos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('orden_id');
            $table->foreign('orden_id')->references('id')->on('ordenes_compra');
            $table->unsignedBigInteger('remito_id');
            $table->foreign('remito_id')->references('id')->on('remitos');
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
        Schema::dropIfExists('compra_remitos');
    }
}
