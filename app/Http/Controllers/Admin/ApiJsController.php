<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\Pieza;
use App\Http\Models\Remito;
use App\Http\Models\Detalle_producto;

class ApiJsController extends Controller
{   
     function getItems(Request $request){
        $data = Pieza::all()->pluck('name','id');
        return $data;
    }

    function getAll(Request $request){
        $data = Pieza::all()->pluck('name','id');
        return $data;
    }
    function getPrecios(Request $request, $id){
        $data = Detalle_producto::where('orden_tipo', 1)->where('pieza_id',$id)->select('created_at','precio')->get();
        return $data;
    }
}
