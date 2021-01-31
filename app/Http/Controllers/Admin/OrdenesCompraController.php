<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Models\OrdenCompra, App\Http\Models\OrdenPedido,App\Http\Models\Compra_Pedidos, App\Http\Models\Proveedor, App\Http\Models\Pieza, App\Http\Models\Detalle_producto;
use Validator,PDF,Auth;

class OrdenesCompraController extends Controller
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
                $input = OrdenCompra::all();
                break;              
            case '0':
                $input = OrdenCompra::where('status','0')->get();
                break;
            case '1':
                $input = OrdenCompra::where('status','1')->get();
                break;
            case '2':
                $input = OrdenCompra::where('status','2')->get();
                break;
            case '3':
                $input = OrdenCompra::where('status','3')->get();
                break;
            case 'trash':
                $input = OrdenCompra::onlyTrashed()->get();
                break;                     
        }
    	  
    	$data = ['input'=> $input];

    	return view('admin.ordenescompra.home', $data);
    }

    public function getOrdenCompraAgregar(){
   		$provs = Proveedor::all()->pluck('name','id');
   		$prods = Pieza::where('status','1')->orderBy('name','asc')->pluck('name','id');
        $orden = OrdenPedido::with(['detalle'])->where('status','0')->get();
        $code = $orden->pluck('codigo','id');

   		$data = ['provs' => $provs,'prods' => $prods, 'orden' => $orden, 'code' => $code ];
        return view('admin.ordenescompra.agregar', $data);
    }

    public function postOrdenCompraAgregar(Request $request){
    	$rules =[
            'orden_id'=>'required',
            'proveedor'=>'required',
            'descripcion'=>'max:100'
        ];

        $messages =[
            'orden_id.required'=>'La Orden de Compra debe corresponder a una Orden de Pedido',
            'proveedor.required'=>'El nombre del proveedor es requerido',
            'descripcion.max'=>'Descripción demasiado extensa'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        
        if($validator->fails()):
            return back()->withErrors($validator)->with('message','Se ha producido un error: ')->with('typealert','danger')->withInput();
        else:
            //Remito
            $input= new OrdenCompra;
            $input -> status =e($request->input('status'));
            $input -> responsable_id = Auth::user()->id;
            $input -> proveedor_id = e($request->input('proveedor'));
            $input -> codigo = 0;
            $input -> descripcion = e($request->input('descripcion'));
            //JSON de piezas
            $productos = e($request->input('productos'));
            $productos = html_entity_decode($productos);    
            $aux = json_decode($productos,true);    
            //return $aux; 
            
            if(empty($request->input('productos'))):
                return back()->withErrors($validator)->with('message','Debe agregar al menos un item al listado.')->with('typealert','danger');
            else:
                if($input->save())://Guarda el Compra

                    foreach($aux as $value){ 
                        //Detalle remito
                        $detalle = new Detalle_producto;
                        $detalle -> pieza_id = $value['pieza_id'];
                        $detalle -> precio = $value['precio'];
                        $detalle -> cantidad_usada = 0;
                        $detalle -> cantidad_req = $value['cantidad'];
                        $detalle -> orden_tipo = 0;//0-compra 1-remito 2-pedido 3-trabajo
                        $detalle -> orden_id = OrdenCompra::all()->last()->id;
                        $detalle->save();
                    }
                    //Genera luego de guardar el remito, el codigo
                    $input-> codigo = 'ODC-'.OrdenCompra::all()->last()->id;
                    $input->save();

                    $cp = new Compra_Pedidos;
                    $cp-> ordenpedido_id = e($request->input('orden_id'));
                    $cp-> ordencompra_id = OrdenCompra::all()->last()->id;
                    $cp->save();

                    return redirect('/admin/ordenescompra/all')->with('message','Orden guardada.')->with('typealert','success');
                endif;
            endif;  
        endif;
    }

    public function getOrdenCompraEdit($id){
    	$oc = OrdenCompra::with(['detalle'])->findOrfail($id);
        $prods = Pieza::where('status','1')->orderBy('name','asc')->pluck('name','id');
    	$provs = Proveedor::all()->pluck('name','id');
   		$data = ['oc'=>$oc, 'provs'=>$provs, 'prods'=>$prods];
        return view('admin.ordenescompra.edit', $data);
    }

    public function postOrdenCompraEdit($id, Request $request){
        $rules =[
            'descripcion'=>'max:100'
        ];

        $messages =[
            'descripcion.max'=>'Descripción demasiado extensa'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        
        if($validator->fails()):
            return back()->withErrors($validator)->with('message','Se ha producido un error: ')->with('typealert','danger')->withInput();
        else:
    	           
            $input= OrdenCompra::findOrfail($id);
            $input -> status = e($request->input('status'));
            $input -> descripcion = e($request->input('descripcion'));

            $productos = e($request->input('productos'));
            $productos = html_entity_decode($productos);    
            $aux = json_decode($productos,true);   

            if(empty($request->input('productos'))):
                return back()->withErrors($validator)->with('message','Debe agregar al menos un item al listado.')->with('typealert','danger')->withInput();
            else:
         		if($input->save()):                
                    //Detalle
                    $detalle = Detalle_producto::all()->where('orden_id', $id);
                    
                    if((count($aux) != count($detalle))){

                        foreach($detalle as $item){   
                            $item->forceDelete();       
                        }

                        foreach($aux as $value){
                            $new = new Detalle_producto;
                            $new -> pieza_id = $value['pieza_id'];
                            $new -> precio = $value['precio'];
                            $new -> cantidad_usada = 0;
                            $new -> cantidad_req = $value['cantidad'];
                            $new -> orden_tipo = 0;//0-compra 1-remito 2-pedido 3-trabajo
                            $new -> orden_id = $id;
                            $new->save();
                       }
                    }
                    else{
                        
                        foreach ($aux as $value) {
                            $array_aux=array("pieza_id"=>$value['pieza_id'], "precio"=>$value['precio'], "cantidad"=>$value['cantidad']);
                        }

                        foreach ($detalle as $item) {
                            $array_detalle=array("pieza_id"=>$item->pieza_id, "precio"=>$item->precio, "cantidad"=>$item->cantidad_req);
                        }

                        for($i=0;   $i<count($array_detalle);   $i++){
                            if($array_aux['pieza_id'] != $array_detalle['pieza_id']){      
                                $distinto = true;
                            }
                            else{
                                $distinto = false;
                            }
                        }

                        if($distinto){
                            foreach($detalle as $item){   
                                $item->forceDelete();       
                            }

                            foreach($aux as $value){
                                $new = new Detalle_producto;
                                $new -> pieza_id = $value['pieza_id'];
                                $new -> precio = $value['precio'];
                                $new -> cantidad_usada = 0;
                                $new -> cantidad_req = $value['cantidad'];
                                $new -> orden_tipo = 0;
                                $new -> orden_id = $id;
                                $new->save();
                            }
                        }
                            
                    }      
                    return redirect('admin/ordenescompra/'.$input->id.'/detalle')->with('message','Se actualizó con éxito.')->with('typealert','success');
                    
                endif;
            endif;
        endif;

    }

   	public function getOrdenCompraDetalle($id){
   		$c = OrdenCompra::findOrFail($id);

        $acum=0;

        $data = ['c'=>$c, 'acum'=>$acum];

        return view('admin.ordenescompra.detalle', $data);
    }

    public function pdf($id){
    	$c = OrdenCompra::findOrfail($id);

        $acum=0;

        $today = Carbon::now()->format('d/m/Y');//fecha actual

        $pdf = PDF::loadView('admin.ordenescompra.pdf',compact('c','acum'));

        return $pdf->stream('Detalle_remito-'.$today.'.pdf');
    
    }

     public function getOrdenCompraDelete($id){
        $c= OrdenCompra::findOrfail($id);

        foreach ($c->detalle as $value) {
            $d = Detalle_producto::where('orden_id', $id)->where('orden_tipo', '0');
            $d->delete();
        }

        if($c->delete()):
            return back()->with('message','Enviada a la papelera.')->with('typealert','danger');
        endif;
    }

    public function getOrdenCompraRestore($id){
        $c= OrdenCompra::onlyTrashed()->where('id', $id)->first();
        $d = Detalle_producto::onlyTrashed()->where('orden_id', $id)->get();
        $c->restore();

        foreach($d as $value){
            $value->restore();
            $value->save();
        }
       
        if($c->save()):
            return redirect('/admin/ordenescompra/all')->with('message','Restaurada con éxito.')->with('typealert','success');
        endif;
    }
}
