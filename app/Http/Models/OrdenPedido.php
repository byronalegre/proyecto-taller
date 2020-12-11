<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrdenPedido extends Model
{
    	use SoftDeletes;

	    protected $dates = ['deleted_at','created_at'];
	    protected $table = 'ordenespedido';
	    protected $hidden = ['updated_at'];

	    public function prods(){
	    	return $this->hasOne(Pieza::class,'id', 'productos');
	    }
}
