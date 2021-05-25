<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Compra_Pedidos extends Model
{
    use softDeletes;

	protected $dates = ['deleted_at','created_at'];
    protected $table = 'compra_pedidos';
    protected $hidden = ['updated_at'];

 //    public function orden(){
	// 	return $this->hasMany(OrdenPedido::class, 'id', 'ordenpedido_id');
	// }

}
