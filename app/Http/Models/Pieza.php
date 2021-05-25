<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pieza extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'piezas';
    protected $hidden = ['created_at','updated_at'];

    public function cat(){
    	return $this->hasOne(Categoria::class, 'id', 'categoria_id');
    }

    public function mark(){
    	return $this->hasOne(Categoria::class, 'id', 'marca');
    }

    public function reserve(){
        return $this->hasMany(Detalle_producto::class, 'pieza_id', 'id')->join('ordenes_trabajo','ordenes_trabajo.id','=','detalle_productos.orden_id')->where('status','0')->where('orden_tipo','3');
    }
}


