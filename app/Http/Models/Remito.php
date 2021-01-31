<?php

namespace App\Http\Models;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Remito extends Model
{    
		use SoftDeletes;

	    protected $dates = ['deleted_at','created_at'];
	    protected $table = 'remitos';
	    protected $hidden = ['updated_at'];
	    
	    public function provs(){
	    	return $this->hasOne(Proveedor::class, 'id', 'proveedor_id');
	    }

	    public function detalle(){
	    	return $this->hasMany(Detalle_producto::class, 'orden_id', 'id')->where('orden_tipo','1');
	    }

	    public function user(){
	    	return $this->hasOne(User::class, 'id', 'responsable_id');
	    }

	    public function orden(){
	    	return $this->hasOne(Compra_Remitos::class, 'remito_id', 'id')->join('ordenes_compra','ordenes_compra.id','=','compra_remitos.orden_id');
	    }

}
