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
        $search = $request->input('search');
        $pag = $request->input('paginate');

        if($pag):
            session(['paginate'=> $pag]);
        else:
            $pag = session('paginate');
        endif;

        if($search){            
            $input = Remito::with(['user:name,lastname,id', 'provs:name,id', 'orden', 'detalle'])
                    ->join('users','users.id','=','remitos.responsable_id')
                    ->select('remitos.*','users.name','users.lastname')
                    ->where('users.name','LIKE','%'.$search.'%')
                    ->orWhere('users.lastname','LIKE','%'.$search.'%')
                    ->join('proveedores','proveedores.id','=','remitos.proveedor_id')
                    ->select('remitos.*','proveedores.name')
                    ->orWhere('proveedores.name','LIKE','%'.$search.'%')
                    ->join('compra_remitos','compra_remitos.remito_id','=','remitos.id')
                    ->join('ordenes_compra','ordenes_compra.id','=','compra_remitos.orden_id')
                    ->select('remitos.*')
                    ->orWhere('ordenes_compra.codigo','LIKE','%'.$search.'%')
                    ->orWhere('remitos.codigo','LIKE','%'.$search.'%')
                    ->orWhere('importe_total','LIKE','%'.$search.'%')
                    // ->orWhere('ordenes_pedido.created_at','LIKE','%'.date('Y-m-d',strtotime($search)).'%')
                    // ->orWhere('ordenes_pedido.fecha_prog','LIKE','%'.date('Y-m-d',strtotime($search)).'%')
                    ->orderBy('remitos.id', 'desc')
                    ->paginate($pag);    
        }
        else{
            switch ($status) {
                case 'new':
                    $input = Remito::with(['user:name,lastname,id', 'provs:name,id', 'orden', 'detalle'])
                    ->whereDate('created_at','>=', Carbon::now()->startOfMonth()->toDateString())
                    ->whereDate('created_at','<', Carbon::now()->tomorrow()->toDateString())
                    ->orderBy('id','desc')
                    ->paginate($pag); 
                    break;
                case 'all':
                    $input = Remito::with(['user:name,lastname,id', 'provs:name,id', 'orden', 'detalle'])
                    ->orderBy('id','desc')
                    ->paginate($pag);
                    break;              
                case 'trash':
                    $input = Remito::with(['user:name,lastname,id', 'provs:name,id', 'orden', 'detalle'])
                    ->onlyTrashed()
                    ->orderBy('id','desc')
                    ->paginate($pag);
                    break;                     
            }
        }

      	$data = ['input'=> $input, 'status'=>$status, 'search'=>$search];

      	return view('admin.remitos.home', $data);
    }

    public function getRemitoAgregar(){
        $provs = Proveedor::all()->pluck('name','id');
        $prods = Pieza::where('status','1')->orderBy('name','asc')->pluck('name','id');
        $orden = OrdenCompra::with(['detalle'])->where('status','0')->get();
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
            
            if(empty($request->input('productos'))||($request->input('productos') == '[]')):
                return back()->with('message','Debe agregar al menos un item al listado.')->with('typealert','danger');
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

                  $oc = OrdenCompra::findOrfail($request->input('orden_id'));
                  $oc-> status = 1;
                  $oc->save();

            		return redirect('/admin/remitos/'.Remito::all()->last()->id.'/detalle')->with('message','Remito guardado.')->with('typealert','success');
            	endif;
           	endif;  
        endif;
    }

    public function getRemitoAgregarDirecto($id){        
        $provs = Proveedor::all()->pluck('name','id');
        $prods = Pieza::where('status','1')->orderBy('name','asc')->pluck('name','id');
        $orden = OrdenCompra::with(['detalle'])->findOrfail($id);

        $data = ['provs' => $provs, 'prods' => $prods, 'orden' => $orden, 'id'=>$id];
        return view('admin.remitos.agregar_directo', $data);
    }

    public function postRemitoAgregarDirecto(Request $request, $id){
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
            $input -> proveedor_id = e($request->input('proveedor'));
            $input -> codigo = 0;
            $input -> importe_total = 0;
            $input -> descripcion = e($request->input('descripcion'));
            //JSON de piezas
            $productos = e($request->input('productos'));
            $productos = html_entity_decode($productos);    
            $aux = json_decode($productos,true); 
            
            if(empty($request->input('productos'))||($request->input('productos') == '[]')):
                return redirect('/admin/ordenescompra/'.$id.'/detalle')->with('message','No puede crear un Remito vacío.')->with('typealert','danger');
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
                  $cr-> orden_id = $id;
                  $cr-> remito_id = Remito::all()->last()->id;
                  $cr->save();

                  $oc = OrdenCompra::findOrfail($id);
                  $oc-> status = 1;
                  $oc->save();

                return redirect('/admin/remitos/'.Remito::all()->last()->id.'/detalle')->with('message','Remito guardado.')->with('typealert','success');
              endif;
            endif;  
        endif;
    }

   	public function getRemitoDetalle($id){
   		$r = Remito::with(['detalle', 'user', 'provs', 'orden'])->findOrfail($id);

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

    public function RemitosPdf(){
        $r = Remito::orderBy('proveedor_id','asc')->get();

        $acum=0;
        
        $today = Carbon::now()->format('d/m/Y');//fecha actual

        $pdf = PDF::loadView('admin.remitos.remitos_pdf',compact('r','acum'));

        return $pdf->stream('Reporte_remitos-'.$today.'.pdf');
    
    }

    public function RemitosMesPdf(){
        $r = Remito::whereYear('created_at', Carbon::now()->format('Y'))->whereMonth('created_at', Carbon::now()->format('m'))->orderBy('proveedor_id','asc')->get();

        $acum=0;
        
        $today = Carbon::now()->format('d/m/Y');//fecha actual

        $pdf = PDF::loadView('admin.remitos.remitos_mes_pdf',compact('r','acum'));

        return $pdf->stream('Reporte_remitos_mes-'.$today.'.pdf');
    }

    public function RemitosAnoPdf(){
        $r = Remito::whereYear('created_at', Carbon::now()->format('Y'))->orderBy('proveedor_id','asc')->get();

        $acum=0;
        
        $today = Carbon::now()->format('d/m/Y');//fecha actual

        $pdf = PDF::loadView('admin.remitos.remitos_ano_pdf',compact('r','acum'));

        return $pdf->stream('Reporte_remitos_año'.now()->format('Y').'-'.$today.'.pdf');
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

    public function order($status, $campo, $direc, Request $request){
        $search = $request->input('search');
        $pag = $request->input('paginate');

        if($pag):
            session(['paginate'=> $pag]);
        else:
            $pag = session('paginate');
        endif;

        if($search){            
            $input = Remito::with(['user:name,lastname,id', 'provs:name,id', 'orden', 'detalle'])
                    ->join('users','users.id','=','remitos.responsable_id')
                    ->select('remitos.*','users.name','users.lastname')
                    ->where('users.name','LIKE','%'.$search.'%')
                    ->orWhere('users.lastname','LIKE','%'.$search.'%')
                    ->join('proveedores','proveedores.id','=','remitos.proveedor_id')
                    ->select('remitos.*','proveedores.name')
                    ->orWhere('proveedores.name','LIKE','%'.$search.'%')
                    ->join('compra_remitos','compra_remitos.remito_id','=','remitos.id')
                    ->join('ordenes_compra','ordenes_compra.id','=','compra_remitos.orden_id')
                    ->select('remitos.*')
                    ->orWhere('ordenes_compra.codigo','LIKE','%'.$search.'%')
                    ->orWhere('remitos.codigo','LIKE','%'.$search.'%')
                    ->orWhere('importe_total','LIKE','%'.$search.'%')
                    // ->orWhere('ordenes_pedido.created_at','LIKE','%'.date('Y-m-d',strtotime($search)).'%')
                    // ->orWhere('ordenes_pedido.fecha_prog','LIKE','%'.date('Y-m-d',strtotime($search)).'%')
                    ->orderBy('remitos.id', 'desc')
                    ->paginate($pag);    
        }
        else{
            switch ($status) {
                case 'new':
                    $input = Remito::with(['user:name,lastname,id', 'provs:name,id', 'orden', 'detalle'])
                    ->whereDate('created_at','>=', Carbon::now()->startOfMonth()->toDateString())
                    ->whereDate('created_at','<', Carbon::now()->tomorrow()->toDateString())
                    ->orderBy($campo, $direc)
                    ->paginate($pag); 
                    break;
                case 'all':
                    $input = Remito::with(['user:name,lastname,id', 'provs:name,id', 'orden', 'detalle'])
                    ->orderBy($campo, $direc)
                    ->paginate($pag);
                    break;              
                case 'trash':
                    $input = Remito::with(['user:name,lastname,id', 'provs:name,id', 'orden', 'detalle'])
                    ->onlyTrashed()
                    ->orderBy($campo, $direc)
                    ->paginate($pag);
                    break;                     
            }
        }

      	$data = ['input'=> $input, 'status'=>$status, 'search'=>$search];

      	return view('admin.remitos.home', $data);
    }
}
