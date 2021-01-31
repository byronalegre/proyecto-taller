<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Compra_Remitos extends Model
{
	use softDeletes;

	protected $dates = ['deleted_at','created_at'];
    protected $table = 'compra_remitos';
    protected $hidden = ['updated_at'];


	// public function remito(){
	// 	return $this->hasOne(Remito::class, 'id', 'remito_id');
	// }

}
