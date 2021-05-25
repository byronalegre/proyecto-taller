<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRemitosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('remitos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigo')->unique();
            $table->unsignedBigInteger('proveedor_id');
            $table->unsignedBigInteger('responsable_id');
            $table->decimal('importe_total', $precision = 11, $scale = 2);            
            $table->text('descripcion');
            $table->foreign('proveedor_id')->references('id')->on('proveedores');
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
        Schema::dropIfExists('remitos');
    }
}
