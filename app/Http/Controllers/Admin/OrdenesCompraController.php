<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Models\OrdenCompra, App\Http\Models\OrdenPedido,App\Http\Models\Compra_Pedidos, App\Http\Models\Proveedor, App\Http\Models\Pieza, App\Http\Models\Detalle_producto, App\Http\Models\Compra_Remitos;
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
        $search = $request->input('search');
        $pag = $request->input('paginate');

        if($pag):
            session(['paginate'=> $pag]);
        else:
            $pag = session('paginate');
        endif;

        if($search){            
            $input = OrdenCompra::with(['user:name,lastname,id', 'provs:name,id', 'orden'])
                    ->join('users','users.id','=','ordenes_compra.responsable_id')
                    ->select('ordenes_compra.*','users.name','users.lastname')
                    ->where('users.name','LIKE','%'.$search.'%')                    
                    ->orWhere('users.lastname','LIKE','%'.$search.'%')
                    ->join('proveedores','proveedores.id','=','ordenes_compra.proveedor_id')
                    ->select('ordenes_compra.*','proveedores.name')
                    ->orWhere('proveedores.name','LIKE','%'.$search.'%')
                    ->join('compra_pedidos','compra_pedidos.ordencompra_id','=','ordenes_compra.id')
                    ->join('ordenes_pedido','ordenes_pedido.id','=','compra_pedidos.ordenpedido_id')
                    ->select('ordenes_compra.*')
                    ->orWhere('ordenes_pedido.codigo','LIKE','%'.$search.'%')
                    ->orWhere('ordenes_compra.codigo','LIKE','%'.$search.'%')
                    // // ->orWhere('ordenes_compra.created_at','LIKE','%'.date('Y-m-d',strtotime($search)).'%')
                    // // ->orWhere('ordenes_compra.fecha_prog','LIKE','%'.date('Y-m-d',strtotime($search)).'%')
                    ->orderBy('ordenes_compra.id', 'desc')
                    ->paginate($pag);
        }
        else{
            switch ($status) {
                case 'new':
                    $input = OrdenCompra::with(['user:name,lastname,id', 'provs:name,id', 'orden'])
                    ->where('status', '0')
                    ->whereDate('created_at','>=', Carbon::now()->startOfMonth()->toDateString())
                    ->orderBy('id','desc')
                    ->paginate($pag); 
                    break;
                case 'all':
                    $input = OrdenCompra::with(['user:name,lastname,id', 'provs:name,id', 'orden'])
                    ->orderBy('id','desc')
                    ->paginate($pag);
                    break;              
                case '0':
                    $input = OrdenCompra::with(['user:name,lastname,id', 'provs:name,id', 'orden'])
                    ->where('status','0')
                    ->orderBy('id','desc')
                    ->paginate($pag);
                    break;
                case '1':
                    $input = OrdenCompra::with(['user:name,lastname,id', 'provs:name,id', 'orden'])
                    ->where('status','1')
                    ->orderBy('id','desc')
                    ->paginate($pag);
                    break;
                case '2':
                    $input = OrdenCompra::with(['user:name,lastname,id', 'provs:name,id', 'orden'])
                    ->where('status','2')
                    ->orderBy('id','desc')
                    ->paginate($pag);
                    break;
                case 'trash':
                    $input = OrdenCompra::with(['user:name,lastname,id', 'provs:name,id', 'orden'])
                    ->onlyTrashed()
                    ->orderBy('id','desc')
                    ->paginate($pag);
                    break;                     
            }
        }

    	$data = ['input'=> $input, 'status'=>$status, 'search'=>$search];

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
                        
            if(empty($request->input('productos'))||($request->input('productos') == '[]')):
                return back()->with('message','Debe agregar al menos un item al listado.')->with('typealert','danger');
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

                    $op = OrdenPedido::findOrfail($request->input('orden_id'));
                    $op-> status = 1;
                    $op->save();

                    return redirect('/admin/ordenescompra/all')->with('message','Orden guardada.')->with('typealert','success');
                endif;
            endif;  
        endif;
    }

    public function getOrdenCompraAgregarDirecto($id){        
        $provs = Proveedor::all()->pluck('name','id');
        $prods = Pieza::where('status','1')->orderBy('name','asc')->pluck('name','id');
        $orden = OrdenPedido::with(['detalle'])->findOrfail($id);

        $data = ['provs' => $provs, 'prods' => $prods, 'orden' => $orden, 'id'=>$id];
        return view('admin.ordenescompra.agregar_directo', $data);
    }

    public function postOrdenCompraAgregarDirecto(Request $request, $id){
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
                        
            if(empty($request->input('productos'))||($request->input('productos') == '[]')):
                return back()->with('message','Debe agregar al menos un item al listado.')->with('typealert','danger');
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
                    $cp-> ordenpedido_id = $id;
                    $cp-> ordencompra_id = OrdenCompra::all()->last()->id;
                    $cp->save();

                    $op = OrdenPedido::findOrfail($id);
                    $op-> status = 1;
                    $op->save();

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

            if((empty($request->input('productos')))||($request->input('productos') == '[]')):
                return redirect('/admin/ordenescompra/'.$id.'/detalle')->with('message','Esta editando la Orden. No puede guardarse sin items.')->with('typealert','danger');
            else:
         		if($input->save()):                
                    //Detalle
                    $detalle = Detalle_producto::all()->where('orden_id', $id)->where('orden_tipo', 0);
                    
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
   		$c = OrdenCompra::with(['detalle', 'user', 'provs', 'orden'])->findOrFail($id);

        $acum=0;

        $data = ['c'=>$c, 'acum'=>$acum];

        return view('admin.ordenescompra.detalle', $data);
    }

    public function pdf($id){
    	$c = OrdenCompra::findOrfail($id);

        $acum=0;

        $today = Carbon::now()->format('d/m/Y');//fecha actual

        $pdf = PDF::loadView('admin.ordenescompra.pdf',compact('c','acum'));

        return $pdf->stream('Detalle_ordendecompra-'.$today.'.pdf');
    
    }

    public function OrdenCompraPdf(){   
        $oc = OrdenCompra::orderBy('proveedor_id','asc')->get();

        $today = Carbon::now()->format('d/m/Y');//fecha actual

        $pdf = PDF::loadView('admin.ordenescompra.ordenescompra_pdf',compact('oc'));

        return $pdf->stream('Reporte_ordenescompra-'.$today.'.pdf');
    
    }

    public function OrdenCompraMesPdf(){
        $oc = OrdenCompra::whereYear('created_at', Carbon::now()->format('Y'))->whereMonth('created_at', Carbon::now()->format('m'))->orderBy('proveedor_id','asc')->get();
        
        $today = Carbon::now()->format('d/m/Y');//fecha actual

        $pdf = PDF::loadView('admin.ordenescompra.ordenescompra_mes_pdf',compact('oc'));

        return $pdf->stream('Reporte_ordenescompra_mes-'.$today.'.pdf');
    }

    public function OrdenCompraAnoPdf(){
        $oc = OrdenCompra::whereYear('created_at', Carbon::now()->format('Y'))->orderBy('proveedor_id','asc')->get();
        
        $today = Carbon::now()->format('d/m/Y');//fecha actual

        $pdf = PDF::loadView('admin.ordenescompra.ordenescompra_ano_pdf',compact('oc'));

        return $pdf->stream('Reporte_ordenescompra_año'.now()->format('Y').'-'.$today.'.pdf');
    }

     public function getOrdenCompraDelete($id){
        $c= OrdenCompra::findOrfail($id);
        $cont = Compra_Remitos::where('orden_id',$id)->count();


        if($cont != 0)
        {
             return back()->with('message','No se puede Anular. Hay '.$cont. ' Remito/s relacionado/s con esta Orden de Compra.')->with('typealert','danger');
        }
        else
        {
            foreach ($c->detalle as $value) {
                $d = Detalle_producto::where('orden_id', $id)->where('orden_tipo', '0');
                $d->delete();
            }

            if($c->delete()):
                return back()->with('message','Enviada a la papelera.')->with('typealert','danger');
            endif;

        }        
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

    public function order($status, $campo, $direc, Request $request){
        $search = $request->input('search');
        $pag = $request->input('paginate');

        if($pag):
            session(['paginate'=> $pag]);
        else:
            $pag = session('paginate');
        endif;

        if($search){            
            $input = OrdenCompra::with(['user:name,lastname,id', 'provs:name,id', 'orden'])
                    ->join('users','users.id','=','ordenes_compra.responsable_id')
                    ->select('ordenes_compra.*','users.name','users.lastname')
                    ->where('users.name','LIKE','%'.$search.'%')                    
                    ->orWhere('users.lastname','LIKE','%'.$search.'%')
                    ->join('proveedores','proveedores.id','=','ordenes_compra.proveedor_id')
                    ->select('ordenes_compra.*','proveedores.name')
                    ->orWhere('proveedores.name','LIKE','%'.$search.'%')
                    ->join('compra_pedidos','compra_pedidos.ordencompra_id','=','ordenes_compra.id')
                    ->join('ordenes_pedido','ordenes_pedido.id','=','compra_pedidos.ordenpedido_id')
                    ->select('ordenes_compra.*')
                    ->orWhere('ordenes_pedido.codigo','LIKE','%'.$search.'%')
                    ->orWhere('ordenes_compra.codigo','LIKE','%'.$search.'%')
                    // // ->orWhere('ordenes_compra.created_at','LIKE','%'.date('Y-m-d',strtotime($search)).'%')
                    // // ->orWhere('ordenes_compra.fecha_prog','LIKE','%'.date('Y-m-d',strtotime($search)).'%')
                    ->orderBy('ordenes_compra.id', 'desc')
                    ->paginate($pag);
        }
        else{
            switch ($status) {
                case 'new':
                    $input = OrdenCompra::with(['user:name,lastname,id', 'provs:name,id', 'orden'])
                    ->where('status', '0')
                    ->whereDate('created_at','>=', Carbon::now()->startOfMonth()->toDateString())
                    ->orderBy($campo, $direc)
                    ->paginate($pag); 
                    break;
                case 'all':
                    $input = OrdenCompra::with(['user:name,lastname,id', 'provs:name,id', 'orden'])
                    ->orderBy($campo, $direc)
                    ->paginate($pag);
                    break;              
                case '0':
                    $input = OrdenCompra::with(['user:name,lastname,id', 'provs:name,id', 'orden'])
                    ->where('status','0')
                    ->orderBy($campo, $direc)
                    ->paginate($pag);
                    break;
                case '1':
                    $input = OrdenCompra::with(['user:name,lastname,id', 'provs:name,id', 'orden'])
                    ->where('status','1')
                    ->orderBy($campo, $direc)
                    ->paginate($pag);
                    break;
                case '2':
                    $input = OrdenCompra::with(['user:name,lastname,id', 'provs:name,id', 'orden'])
                    ->where('status','2')
                    ->orderBy($campo, $direc)
                    ->paginate($pag);
                    break;
                case 'trash':
                    $input = OrdenCompra::with(['user:name,lastname,id', 'provs:name,id', 'orden'])
                    ->onlyTrashed()
                    ->orderBy($campo, $direc)
                    ->paginate($pag);
                    break;                     
            }
        }

    	$data = ['input'=> $input, 'status'=>$status, 'search'=>$search];

    	return view('admin.ordenescompra.home', $data);
    }
}
