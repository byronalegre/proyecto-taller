<?php

namespace App\Http\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrdenTrabajo extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'ordenes_trabajo';
    protected $hidden = ['created_at','updated_at'];

    public function work(){
    	return $this->hasOne(Categoria::class, 'id', 'tarea_id');
    }

    public function detalle(){
    	return $this->hasMany(Detalle_producto::class, 'orden_id', 'id')->where('orden_tipo','3');
    }

    public function user(){
    	return $this->hasOne(User::class, 'id', 'responsable_id');
    }
}
