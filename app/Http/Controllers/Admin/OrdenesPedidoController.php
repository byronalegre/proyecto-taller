<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Models\OrdenPedido, App\Http\Models\Pieza, App\Http\Models\Detalle_producto, App\Http\Models\Compra_Pedidos;
use Validator,PDF,Auth;

class OrdenesPedidoController extends Controller
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
            $input = OrdenPedido::with(['user:name,lastname,id'])
                    ->join('users','users.id','=','ordenes_pedido.responsable_id')
                    ->select('ordenes_pedido.*','users.name','users.lastname')
                    ->where('users.name','LIKE','%'.$search.'%')
                    ->orWhere('users.lastname','LIKE','%'.$search.'%')
                    ->orWhere('codigo','LIKE','%'.$search.'%')  
                    // ->orWhere('ordenes_pedido.created_at','LIKE','%'.date('Y-m-d',strtotime($search)).'%')
                    // ->orWhere('ordenes_pedido.fecha_prog','LIKE','%'.date('Y-m-d',strtotime($search)).'%')
                    ->orderBy('ordenes_pedido.id', 'desc')
                    ->paginate($pag);    
        }
        else{
            switch ($status) {
                case 'new':
                    $input = OrdenPedido::with(['user:name,lastname,id'])
                    ->where('status', '0')
                    ->whereDate('created_at','>=', Carbon::now()->startOfMonth()->toDateString())
                    ->orderBy('id','desc')
                    ->paginate($pag); 
                    break;
                case 'all':
                    $input = OrdenPedido::with(['user:name,lastname,id'])
                    ->orderBy('id','desc')
                    ->paginate($pag);
                    break;              
                case '0':
                    $input = OrdenPedido::with(['user:name,lastname,id'])
                    ->where('status','0')
                    ->orderBy('id','desc')
                    ->paginate($pag);
                    break;
                case '1':
                    $input = OrdenPedido::with(['user:name,lastname,id'])
                    ->where('status','1')
                    ->orderBy('id','desc')
                    ->paginate($pag);
                    break;
                case '2':
                    $input = OrdenPedido::with(['user:name,lastname,id'])
                    ->where('status','2')
                    ->orderBy('id','desc')
                    ->paginate($pag);
                    break;
                case 'trash':
                    $input = OrdenPedido::with(['user:name,lastname,id'])
                    ->onlyTrashed()
                    ->orderBy('id','desc')
                    ->paginate($pag);
                    break;                     
            }
        }

    	$data = ['input'=> $input, 'status'=>$status, 'search'=>$search];

    	return view('admin.ordenespedido.home', $data);
    }

    public function getOrdenPedidoAgregar(){
        $prods = Pieza::where('status','1')->orderBy('name','asc')->get(['id','name','cantidad','cantidad_min']);

   		$data = ['prods' => $prods];
        return view('admin.ordenespedido.agregar', $data);
    }

    public function postOrdenPedidoAgregar(Request $request){
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
            //Remito
            $input= new OrdenPedido;
            $input -> status = 0;//cambiado
            $input -> responsable_id = Auth::user()->id;
            $input -> fecha_prog = e($request->input('fecha_prog'));
            $input -> codigo = 0;
            $input -> descripcion = e($request->input('descripcion'));
            //JSON de piezas
            $productos = e($request->input('productos'));
            $productos = html_entity_decode($productos);    
            $aux = json_decode($productos,true);     
            
            if((empty($request->input('productos'))||($request->input('productos') == '[]'))):
                return back()->with('message','Debe agregar al menos un item al listado.')->with('typealert','danger')->withInput();
            else:
                if($input->save())://Guarda
                    foreach($aux as $value){ 
                        //Detalle 
                        $detalle = new Detalle_producto;
                        $detalle -> pieza_id = $value['pieza_id'];
                        $detalle -> precio = 0;
                        $detalle -> cantidad_usada = 0;
                        $detalle -> cantidad_req = $value['cantidad'];
                        $detalle -> orden_tipo = 2; //0-compra 1-remito 2-pedido 3-trabajo
                        $detalle -> orden_id = OrdenPedido::all()->last()->id;
                        $detalle->save();
                    }
                    //Genera luego de guardar el remito, el codigo
                    $input-> codigo = 'ODP-'.OrdenPedido::all()->last()->id;
                    $input->save();

                    return redirect('/admin/ordenespedido/all')->with('message','Orden guardada.')->with('typealert','success');
                endif;
            endif;  
        endif;
    }

    public function getOrdenPedidoEdit($id){
    	$op = OrdenPedido::with(['detalle'])->findOrfail($id);
        $prods = Pieza::where('status','1')->orderBy('name','asc')->get(['id','name','cantidad','cantidad_min']);

        $data = ['op'=>$op, 'prods'=>$prods];
        return view('admin.ordenespedido.edit', $data);
    }

    public function postOrdenPedidoEdit($id, Request $request){
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
                   
            $input= OrdenPedido::with(['detalle'])->findOrfail($id);
            $input -> status = e($request->input('status'));
            $input -> descripcion = e($request->input('descripcion'));

            $productos = e($request->input('productos'));
            $productos = html_entity_decode($productos);    
            $aux = json_decode($productos,true);   
         //   return $aux;

            if((empty($request->input('productos'))||($request->input('productos') == '[]'))):
                return redirect('/admin/ordenespedido/'.$id.'/detalle')->with('message','Esta editando la Orden. No puede guardarse sin items.')->with('typealert','danger');
            else:
                if($input->save()):                
                    //Detalle
                    $detalle = Detalle_producto::all()->where('orden_id', $id)->where('orden_tipo', 2);
                    
                    if((count($aux) != count($detalle))){

                        foreach($detalle as $item){   
                            $item->forceDelete();       
                        }

                        foreach($aux as $value){
                            $new = new Detalle_producto;
                            $new -> pieza_id = $value['pieza_id'];
                            $new -> precio = 0;
                            $new -> cantidad_usada = 0;
                            $new -> cantidad_req = $value['cantidad'];
                            $new -> orden_tipo = 2;//0-compra 1-remito 2-pedido 3-trabajo
                            $new -> orden_id = $id;
                            $new->save();
                       }
                    }
                    else{
                        
                        foreach ($aux as $value) {
                            $array_aux=array("pieza_id"=>$value['pieza_id'], "cantidad"=>$value['cantidad']);
                        }

                        foreach ($detalle as $item) {
                            $array_detalle=array("pieza_id"=>$item->pieza_id, "cantidad"=>$item->cantidad_req);
                        }

                        // for($i=0;   $i<count($array_detalle);   $i++){
                        //     if($array_aux['pieza_id'] != $array_detalle['pieza_id']){      
                        //         $distinto = true;
                        //     }
                        //     else{
                        //         $distinto = false;
                        //     }
                        // }

                        foreach($array_detalle as $item) {
                            if(in_array($item, $array_aux) ){
                                $distinto = false;
                            }
                            else{
                                $distinto = true;
                            }
                        }

                        if($distinto){
                            foreach($detalle as $item){   
                                $item->forceDelete();       
                            }

                            foreach($aux as $value){
                                $new = new Detalle_producto;
                                $new -> pieza_id = $value['pieza_id'];
                                $new -> precio = 0;
                                $new -> cantidad_usada = 0;
                                $new -> cantidad_req = $value['cantidad'];
                                $new -> orden_tipo = 2;
                                $new -> orden_id = $id;
                                $new->save();
                            }
                        }
                            
                    }      
                    return redirect('admin/ordenespedido/'.$input->id.'/detalle')->with('message','Se actualizó con éxito.')->with('typealert','success');
                    
                endif;
            endif;
        endif;

    }

   	public function getOrdenPedidoDetalle($id){
   		$op = OrdenPedido::with(['detalle', 'user'])->findOrFail($id);
   		
   		$data = ['op' => $op];
   		return view('admin.ordenespedido.detalle', $data);
    }

    public function pdf($id){
    	$op = OrdenPedido::findOrFail($id);

        $today = Carbon::now()->format('d/m/Y');//fecha actual

        $pdf = PDF::loadView('admin.ordenespedido.pdf',compact('op'));

        return $pdf->stream('Detalle_ordenpedido-'.$today.'.pdf');
    
    }

    public function OrdenPedidoPdf(){   
        $op = OrdenPedido::all();

        $today = Carbon::now()->format('d/m/Y');//fecha actual

        $pdf = PDF::loadView('admin.ordenespedido.ordenespedido_pdf', compact('op'));

        return $pdf->stream('Reporte_ordenespedido-'.$today.'.pdf');
    
    }

    public function OrdenPedidoMesPdf(){
        $op = OrdenPedido::whereYear('created_at', Carbon::now()->format('Y'))->whereMonth('created_at', Carbon::now()->format('m'))->get();
        
        $today = Carbon::now()->format('d/m/Y');//fecha actual

        $pdf = PDF::loadView('admin.ordenespedido.ordenespedido_mes_pdf', compact('op'));

        return $pdf->stream('Reporte_ordenespedido_mes-'.$today.'.pdf');
    }

    public function OrdenPedidoAnoPdf(){
        $op = OrdenPedido::whereYear('created_at', Carbon::now()->format('Y'))->get();
        
        $today = Carbon::now()->format('d/m/Y');//fecha actual

        $pdf = PDF::loadView('admin.ordenespedido.ordenespedido_ano_pdf', compact('op'));

        return $pdf->stream('Reporte_ordenespedido_año'.now()->format('Y').'-'.$today.'.pdf');
    }

     public function getOrdenPedidoDelete($id){
        $op= OrdenPedido::with(['detalle'])->findOrfail($id);
        $cont = Compra_Pedidos::where('ordenpedido_id',$id)->count();

        if($cont != 0)
        {
             return back()->with('message','No se puede Anular. Hay '.$cont. ' Orden/es de Compra relacionada/s con esta Orden de Pedido.')->with('typealert','danger');
        }
        else
        {
            foreach ($op->detalle as $value) {
            $d = Detalle_producto::where('orden_id', $id)->where('orden_tipo', '2');
            $d->delete();
            }

            if($op->delete()):
                return back()->with('message','Enviada a la papelera.')->with('typealert','danger');
            endif;

        }
        
    }

    public function getOrdenPedidoRestore($id){
        $op= OrdenPedido::onlyTrashed()->where('id', $id)->first();
        $d = Detalle_producto::onlyTrashed()->where('orden_id', $id)->get();
        $op->restore();

        foreach($d as $value){
            $value->restore();
            $value->save();
        }
       
        if($op->save()):
            return redirect('/admin/ordenespedido/all')->with('message','Restaurada con éxito.')->with('typealert','success');
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
            $input = OrdenPedido::with(['user:name,lastname,id'])
                    ->join('users','users.id','=','ordenes_pedido.responsable_id')
                    ->select('ordenes_pedido.*','users.name','users.lastname')
                    ->where('users.name','LIKE','%'.$search.'%')
                    ->orWhere('users.lastname','LIKE','%'.$search.'%')
                    ->orWhere('codigo','LIKE','%'.$search.'%')  
                    // ->orWhere('ordenes_pedido.created_at','LIKE','%'.date('Y-m-d',strtotime($search)).'%')
                    // ->orWhere('ordenes_pedido.fecha_prog','LIKE','%'.date('Y-m-d',strtotime($search)).'%')
                    ->orderBy('ordenes_pedido.id', 'desc')
                    ->paginate($pag);    
        }
        else{
            switch ($status) {
                case 'new':
                    $input = OrdenPedido::with(['user:name,lastname,id'])
                    ->where('status', '0')
                    ->whereDate('created_at','>=', Carbon::now()->startOfMonth()->toDateString())
                    ->orderBy($campo, $direc)
                    ->paginate($pag); 
                    break;
                case 'all':
                    $input = OrdenPedido::with(['user:name,lastname,id'])
                    ->orderBy($campo, $direc)
                    ->paginate($pag);
                    break;              
                case '0':
                    $input = OrdenPedido::with(['user:name,lastname,id'])
                    ->where('status','0')
                    ->orderBy($campo, $direc)
                    ->paginate($pag);
                    break;
                case '1':
                    $input = OrdenPedido::with(['user:name,lastname,id'])
                    ->where('status','1')
                    ->orderBy($campo, $direc)
                    ->paginate($pag);
                    break;
                case '2':
                    $input = OrdenPedido::with(['user:name,lastname,id'])
                    ->where('status','2')
                    ->orderBy($campo, $direc)
                    ->paginate($pag);
                    break;
                case 'trash':
                    $input = OrdenPedido::with(['user:name,lastname,id'])
                    ->onlyTrashed()
                    ->orderBy($campo, $direc)
                    ->paginate($pag);
                    break;                     
            }
        }

    	$data = ['input'=> $input, 'status'=>$status, 'search'=>$search];

    	return view('admin.ordenespedido.home', $data);
    }
}
