<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoriaPiezasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historia_piezas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pieza_id');
            $table->unsignedBigInteger('responsable_id');
            $table->text('old_values');
            $table->text('new_values');
            $table->foreign('pieza_id')->references('id')->on('piezas');
            
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
        Schema::dropIfExists('historia_pieza');
    }
}
