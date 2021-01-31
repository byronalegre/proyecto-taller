<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Models\Remito, App\Http\Models\Proveedor, App\Http\Models\Pieza, App\Http\Models\OrdenCompra, App\Http\Models\Detalle_producto, App\Http\Models\Compra_Remitos;
use Validator,PDF,Auth;

class RemitosController extends Controller
{
    public function __construct(){
    	$this->middleware('auth');
    	$this->middleware('estadoUsuario');
    	$this->middleware('permisosUsuario');
    	$this->middleware('isadmin');

    }

    public function getHome($status, Request $request){
        switch ($status) {
            case 'all':
                $input = Remito::all();
                break;
            case 'trash':
                $input = Remito::onlyTrashed()->get();
                break;            
        }
    	  
      	$data = ['input'=> $input];

      	return view('admin.remitos.home', $data);
    }

    public function getRemitoAgregar(){
     		$provs = Proveedor::all()->pluck('name','id');
     		$prods = Pieza::where('status','1')->orderBy('name','asc')->pluck('name','id');
        $orden = OrdenCompra::with(['detalle'])->where('status','1')->get();
        $code = $orden->pluck('codigo','id');

     		$data = ['provs' => $provs, 'prods' => $prods, 'orden' => $orden, 'code' => $code ];
        return view('admin.remitos.agregar', $data);
    }

    public function postRemitoAgregar(Request $request){
        $rules =[
            'orden_id'=>'required',
            'proveedor'=>'required',
            'descripcion'=>'max:100'
        ];

        $messages =[
            'orden_id.required'=>'El remito debe corresponder a una Orden de Compra',
            'proveedor.required'=>'El nombre del proveedor es requerido.',
            'descripcion.max'=>'Descripción demasiado extensa'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        
        if($validator->fails()):
            return back()->withErrors($validator)->with('message','Se ha producido un error: ')->with('typealert','danger')->withInput();
        else:
           	//Remito
          	$acum = 0;
            $input= new Remito;
            $input -> responsable_id = Auth::user()->id; 
            //$input -> orden_id = e($request->input('orden_id'));
            $input -> proveedor_id = e($request->input('proveedor'));
            $input -> codigo = 0;
            $input -> importe_total = 0;
            $input -> descripcion = e($request->input('descripcion'));
            //JSON de piezas
            $productos = e($request->input('productos'));
            $productos = html_entity_decode($productos);    
			      $aux = json_decode($productos,true); 	   
           // return $aux;
            if(empty($request->input('productos'))):
                return back()->withErrors($validator)->with('message','Debe agregar al menos un item al listado.')->with('typealert','danger')->withInput();
            else:
            	if($input->save()):

	            	//Guarda el Detalle
	            	foreach($aux as $value){ 
	            		//Detalle remito
	            		$detalle = new Detalle_producto;
	            		$detalle -> pieza_id = $value['pieza_id'];
	            		$detalle -> precio = $value['precio'];
                  $detalle -> cantidad_usada = 0;
	            		$detalle -> cantidad_req = $value['cantidad'];
                  $detalle -> orden_tipo = 1; //0-compra 1-remito 2-pedido 3-trabajo
	            		$detalle -> orden_id = Remito::all()->last()->id;
	            		$detalle->save();
                  
	            		//Acumula importe total
                  $acum += $value['precio'] * $value['cantidad'];

                  //Modifica stock de piezas
                  $p = Pieza::findOrFail($value['pieza_id']);//busca la pieza
                  $p-> cantidad += $value['cantidad'];//aumenta
                  $p->save();//guarda
	                }
                  //Genera luego de guardar el remito, el codigo y coloca el importe total
                  $input-> codigo = 'RC-'.Remito::all()->last()->id;
                  $input-> importe_total = $acum;
                  $input->save();

                  $cr = new Compra_Remitos;
                  $cr-> orden_id = e($request->input('orden_id'));
                  $cr-> remito_id = Remito::all()->last()->id;
                  $cr->save();

            		return redirect('/admin/remitos/all')->with('message','Remito guardado.')->with('typealert','success');
            	endif;
           	endif;  
        endif;
    }

   	public function getRemitoDetalle($id){
   		$r = Remito::findOrfail($id);

   		$acum=0;

   		$data = ['r'=>$r, 'acum'=>$acum];

   		return view('admin.remitos.detalle', $data);
    }

    public function pdf($id){
      	$r = Remito::findOrfail($id);

     		$acum=0;

        $today = Carbon::now()->format('d/m/Y');//fecha actual

        $pdf = PDF::loadView('admin.remitos.pdf',compact('r','acum'));

        return $pdf->stream('Detalle_remito-'.$today.'.pdf');
    
    }

     public function getRemitosDelete($id){
        $r = Remito::with(['detalle'])->findOrfail($id);

        foreach ($r->detalle as $value) {
            $p = Pieza::findOrFail($value['pieza_id']);
            $p-> cantidad -= $value['cantidad_req'];
            $p->save();

            $d = Detalle_producto::where('orden_id', $id)->where('orden_tipo', '1');
            $d->delete();
        }

        if($r->delete()):
            return back()->with('message','Enviado a la papelera.')->with('typealert','danger');
        endif;
    }

    public function getRemitosRestore($id){
        $r= Remito::onlyTrashed()->where('id', $id)->first();
       	$d = Detalle_producto::onlyTrashed()->where('orden_id', $id)->get();
       	$r->restore();

       	foreach($d as $value){
       		$value->restore();
       		$value->save();
       	}
       
        if($r->save()):
        	$a = Remito::with(['detalle'])->findOrfail($id);
        	
	        foreach ($a->detalle as $value) {
	            $p = Pieza::findOrFail($value['pieza_id']);
	            $p-> cantidad += $value['cantidad_req'];
	            $p->save();
	        }

          return redirect('/admin/remitos/all')->with('message','Restaurado con éxito.')->with('typealert','success');
        endif;
    }
}
