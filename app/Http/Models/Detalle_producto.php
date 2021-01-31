<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detalle_producto extends Model
{
    	use SoftDeletes;

	    protected $dates = ['deleted_at'];
	    protected $table = 'detalle_productos';
	    protected $hidden = ['created_at','updated_at'];
	    
	    public function prods(){
	    	return $this->hasMany(Pieza::class, 'id', 'pieza_id');
	    }

}
