<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tarea extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at','created_at'];
    protected $table = 'tareas';
    protected $hidden = ['updated_at'];

    public function prods(){
    	return $this->hasOne(Pieza::class,'id', 'productos');
    }

    public function work(){
    	return $this->hasOne(Categoria::class, 'id', 'tarea_id');
    }
   
}