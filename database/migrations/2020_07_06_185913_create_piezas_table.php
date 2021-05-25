<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePiezasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('piezas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigo')->unique();
            $table->integer('status');
            $table->string('name');            
            $table->string('slug');
            $table->integer('categoria_id');
            $table->string('file_path');
            $table->string('image');
            $table->integer('cantidad_min');
            $table->integer('cantidad');            
            $table->integer('marca');
            $table->integer('deposito');
            $table->text('content');
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
        Schema::dropIfExists('piezas');
    }
}
