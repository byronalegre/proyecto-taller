<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrdenCompra extends Model
{
		use SoftDeletes;

	    protected $dates = ['deleted_at','created_at'];
	    protected $table = 'ordenescompra';
	    protected $hidden = ['updated_at'];

	     public function provs(){
	    	return $this->hasOne(Proveedor::class, 'id', 'proveedor_id');
	    }

	    public function prods(){
	    	return $this->hasOne(Pieza::class,'id', 'productos');
	    }
}
