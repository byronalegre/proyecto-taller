<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\Historia_pieza, App\Http\Models\Categoria, App\Http\Models\Detalle_producto;
use Validator;

class HistoriaPiezasController extends Controller
{
    public function __construct(){
    	$this->middleware('auth');
    	$this->middleware('estadoUsuario');
    	$this->middleware('permisosUsuario');
    	$this->middleware('isadmin');

    }

    public function getHome($id){
    	$log = Historia_pieza::with(['user'])->where('pieza_id', $id)->get();
    	$data = ['log'=> $log, 'id'=>$id];
    	return view('admin.historia_piezas.home', $data);
    }

    public function getHistoriaDetalle($id){
        $log = Historia_pieza::with(['user'])->findOrFail($id);
        $cat = Categoria::all()->where('seccion',0)->pluck('name','id');
        $mark = Categoria::all()->where('seccion',1)->pluck('name','id');
        $data = ['log'=> $log, 'mark'=>$mark, 'cat'=>$cat];
        return view('admin.historia_piezas.detalle', $data);
    }

    public function getHistoriaPrecio($id){
        $precio = Detalle_producto::where('orden_tipo', 1)->where('pieza_id',$id)->get();
        $data = ['id'=>$id,'precio'=>$precio];
        
        return view('admin.historia_piezas.historia_precios', $data);
    }

}
