<?php

namespace App\Http\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrdenCompra extends Model
{
		use SoftDeletes;

	    protected $dates = ['deleted_at'];
	    protected $table = 'ordenes_compra';
	    protected $hidden = ['updated_at','created_at'];

	    public function provs(){
	    	return $this
			->hasOne(Proveedor::class, 'id', 'proveedor_id');
	    }

	    public function detalle(){
	    	return $this
			->hasMany(Detalle_producto::class, 'orden_id', 'id')
			->where('orden_tipo','0');
	    }

	    public function user(){
	    	return $this
			->hasOne(User::class, 'id', 'responsable_id');
	    }

	    public function orden(){
	    	return $this
			->hasOne(Compra_Pedidos::class, 'ordencompra_id', 'id')
			->join('ordenes_pedido','ordenes_pedido.id','=','compra_pedidos.ordenpedido_id');
	    }
}
