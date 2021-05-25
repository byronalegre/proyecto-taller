<?php

namespace App\Http\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrdenPedido extends Model
{
    	use SoftDeletes;

	    protected $dates = ['deleted_at'];
	    protected $table = 'ordenes_pedido';
	    protected $hidden = ['created_at','updated_at'];

	    public function detalle(){
	    	return $this->hasMany(Detalle_producto::class, 'orden_id', 'id')->where('orden_tipo','2');
	    }

	    public function user(){
	    	return $this->hasOne(User::class, 'id', 'responsable_id');
	    }
}
