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

    public function getHome($id, Request $request){
        $pag = $request->input('paginate');

        if($pag):
            session(['paginate'=> $pag]);
        else:
            $pag = session('paginate');
        endif;

    	$log = Historia_pieza::with(['user'])
        ->where('pieza_id', $id)
        ->paginate($pag);

    	$data = ['log'=> $log, 'id'=>$id];
    	return view('admin.historia_piezas.home', $data);
    }

    public function getHistoriaDetalle($id){
        $log = Historia_pieza::with(['user'])
        ->findOrFail($id);

        $cat = Categoria::all()
        ->pluck('name','id');

        $data = ['log'=> $log, 'cat'=>$cat];
        return view('admin.historia_piezas.detalle', $data);
    }

    public function getHistoriaPrecio($id, Request $request){
        $pag = $request->input('paginate');

        if($pag):
            session(['paginate'=> $pag]);
        else:
            $pag = session('paginate');
        endif;

        $precio = Detalle_producto::where('orden_tipo', 1)
        ->where('pieza_id',$id)
        ->orderByDesc('created_at')
        ->paginate($pag);
        
        $data = ['id'=>$id, 'precio'=>$precio];
        
        return view('admin.historia_piezas.historia_precios', $data);
    }

}
