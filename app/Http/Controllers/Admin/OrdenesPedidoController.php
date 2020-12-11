<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Models\OrdenPedido, App\Http\Models\Pieza;
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
        switch ($status) {
            case 'all':
                $input = OrdenPedido::with(['prods'])->orderBy('id','desc')->paginate(config('settings.pag'));
                break;              
            case '0':
                $input = OrdenPedido::with(['prods'])->where('status','0')->orderBy('id','desc')->paginate(config('settings.pag'));
                break;
            case '1':
                $input = OrdenPedido::with(['prods'])->where('status','1')->orderBy('id','desc')->paginate(config('settings.pag'));
                break;
            case '2':
                $input = OrdenPedido::with(['prods'])->where('status','2')->orderBy('id','desc')->paginate(config('settings.pag'));
                break;
            case 'trash':
                $input = OrdenPedido::with(['prods'])->onlyTrashed()->orderBy('id','desc')->paginate(config('settings.pag'));
                break;                     
        }
    	  
    	$data = ['input'=> $input];

    	return view('admin.ordenespedido.home', $data);
    }

    public function getOrdenPedidoAgregar(){
   		$prods = Pieza::where('status','1')->whereRaw('cantidad_min >= cantidad')->pluck('name','id');		

   		$data = ['prods' => $prods];
        return view('admin.ordenespedido.agregar', $data);
    }

    public function postOrdenPedidoAgregar(Request $request){
    	$rules =[
            'codigo'=>'required'
        ];

        $messages =[
            'codigo.required'=>'El código es requerido.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        
        if($validator->fails()):
            return back()->withErrors($validator)->with('message','Se ha producido un error: ')->with('typealert','danger')->withInput();
        else:
           
            $input= new OrdenPedido;
            $input -> responsable = '['. Auth::user()->id .'] ' . Auth::user()->name .' '. Auth::user()->lastname;
            $input -> status = e($request->input('status'));
            $input -> codigo = e($request->input('codigo'));
            $input -> descripcion = e($request->input('descripcion'));
            $productos = e($request->input('productos'));
            $productos = html_entity_decode($productos);         			 
			$input-> productos = $productos;  
			
            if($input-> productos == '0'):
                return back()->withErrors($validator)->with('message','Debe agregar al menos un item al listado.')->with('typealert','danger')->withInput();
            else:             
	     		if($input->save()):
	            	return redirect('/admin/ordenespedido/all')->with('message','Orden de pedido guardada.')->with('typealert','success');
	            endif;
	        endif;

        endif;
    }

    public function getOrdenPedidoEdit($id){
    	$op = OrdenPedido::findOrfail($id);
   		$data = ['op'=>$op];
        return view('admin.ordenespedido.edit', $data);
    }

    public function postOrdenPedidoEdit($id, Request $request){
    	           
        $input= OrdenPedido::findOrfail($id);
        $input -> status = e($request->input('status'));
        $input -> descripcion = e($request->input('descripcion'));
       
 		if($input->save()):
        	return redirect('admin/ordenespedido/'.$input->id.'/detalle')->with('message','Se actualizo con éxito.')->with('typealert','success');
        endif;

    }

   	public function getOrdenPedidoDetalle($id){
   		$op = OrdenPedido::findOrFail($id);
   		$a = json_decode($op->productos,true);
   		$acum = 0;
   		$data = ['op' => $op, 'a'=>$a, 'acum'=>$acum];
   		return view('admin.ordenespedido.detalle', $data);
    }

    public function pdf($id){
    	$op = OrdenPedido::findOrFail($id);
    	$a = json_decode($op->productos,true);
    	$acum = 0;
        $today = Carbon::now()->format('d/m/Y');//fecha actual

        $pdf = PDF::loadView('admin.ordenespedido.pdf',compact('a','op','acum'));

        return $pdf->stream('Detalle_ordenpedido-'.$today.'.pdf');
    
    }

     public function getOrdenPedidoDelete($id){
        $op= OrdenPedido::findOrfail($id);

        if($op->delete()):
            return back()->with('message','Enviada a la papelera.')->with('typealert','danger');
        endif;
    }

    public function getOrdenPedidoRestore($id){
        $op= OrdenPedido::onlyTrashed()->where('id', $id)->first();
        $op->restore();
       
        if($op->save()):
            return redirect('/admin/ordenespedido/all')->with('message','Restaurada con éxito.')->with('typealert','success');
        endif;
    }
}
