<?php

namespace App\Http\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Historia_pieza extends Model
{
	    protected $table = 'historia_piezas';
	    protected $hidden = ['created_at','updated_at'];

	    // public function prods(){
	    // 	return $this->hasOne(Pieza::class, 'id', 'pieza_id');
	    // }

	    public function user(){
	    	return $this->hasOne(User::class, 'id', 'responsable_id');
	    }
}
