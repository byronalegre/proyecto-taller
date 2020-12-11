<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Models\OrdenCompra, App\Http\Models\Proveedor, App\Http\Models\Pieza;
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
                $input = OrdenCompra::with(['provs','prods'])->orderBy('id','desc')->paginate(config('settings.pag'));
                break;              
            case '0':
                $input = OrdenCompra::with(['provs','prods'])->where('status','0')->orderBy('id','desc')->paginate(config('settings.pag'));
                break;
            case '1':
                $input = OrdenCompra::with(['provs','prods'])->where('status','1')->orderBy('id','desc')->paginate(config('settings.pag'));
                break;
            case '2':
                $input = OrdenCompra::with(['provs','prods'])->where('status','2')->orderBy('id','desc')->paginate(config('settings.pag'));
                break;
            case '3':
                $input = OrdenCompra::with(['provs','prods'])->where('status','3')->orderBy('id','desc')->paginate(config('settings.pag'));
                break;
            case 'trash':
                $input = OrdenCompra::with(['provs','prods'])->onlyTrashed()->orderBy('id','desc')->paginate(config('settings.pag'));
                break;                     
        }
    	  
    	$data = ['input'=> $input];

    	return view('admin.ordenescompra.home', $data);
    }

    public function getOrdenCompraAgregar(){
   		$provs = Proveedor::all()->pluck('name','id');
   		$prods = Pieza::where('status','1')->pluck('name','id');
   		$data = ['provs' => $provs,'prods' => $prods];
        return view('admin.ordenescompra.agregar', $data);
    }

    public function postOrdenCompraAgregar(Request $request){
    	$rules =[
            'proveedor'=>'required',
            'codigo'=>'required'
        ];

        $messages =[
            'proveedor.required'=>'El nombre del proveedor es requerido.',
            'codigo.required'=>'El código es requerido.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        
        if($validator->fails()):
            return back()->withErrors($validator)->with('message','Se ha producido un error: ')->with('typealert','danger')->withInput();
        else:
           
            $input= new OrdenCompra;
            $input -> responsable = '['. Auth::user()->id .'] ' . Auth::user()->name .' '. Auth::user()->lastname;
            $input -> status =e($request->input('status'));
            $input -> proveedor_id = e($request->input('proveedor'));
            $input -> codigo = e($request->input('codigo'));
            $input -> descripcion = e($request->input('descripcion'));
            $productos = e($request->input('productos'));
            $productos = html_entity_decode($productos);         			 
			$input-> productos = $productos;  
			
            if($input-> productos == '0'):
                return back()->withErrors($validator)->with('message','Debe agregar al menos un item al listado.')->with('typealert','danger')->withInput();
            else:             
	     		if($input->save()):
	            	return redirect('/admin/ordenescompra/all')->with('message','Orden de compra guardada.')->with('typealert','success');
	            endif;
	        endif;

        endif;
    }

    public function getOrdenCompraEdit($id){
    	$oc = OrdenCompra::findOrfail($id);
    	$provs = Proveedor::all()->pluck('name','id');
   		$data = ['oc'=>$oc, 'provs'=>$provs];
        return view('admin.ordenescompra.edit', $data);
    }

    public function postOrdenCompraEdit($id, Request $request){
    	           
        $input= OrdenCompra::findOrfail($id);
        $input -> status = e($request->input('status'));
        $input -> descripcion = e($request->input('descripcion'));
       
 		if($input->save()):
        	return redirect('admin/ordenescompra/'.$input->id.'/detalle')->with('message','Se actualizo con éxito.')->with('typealert','success');
        endif;

    }

   	public function getOrdenCompraDetalle($id){
   		$c = OrdenCompra::findOrFail($id);
   		$a = json_decode($c->productos,true);
   		$acum = 0;
   		$data = ['c' => $c, 'a'=>$a, 'acum'=>$acum];
   		return view('admin.ordenescompra.detalle', $data);
    }

    public function pdf($id){
    	$c = OrdenCompra::findOrFail($id);
    	$a = json_decode($c->productos,true);
    	$acum = 0;
        $today = Carbon::now()->format('d/m/Y');//fecha actual

        $pdf = PDF::loadView('admin.ordenescompra.pdf',compact('a','c','acum'));

        return $pdf->stream('Detalle_ordencompra-'.$today.'.pdf');
    
    }

     public function getOrdenCompraDelete($id){
        $c= OrdenCompra::findOrfail($id);

        if($c->delete()):
            return back()->with('message','Enviada a la papelera.')->with('typealert','danger');
        endif;
    }

    public function getOrdenCompraRestore($id){
        $c= OrdenCompra::onlyTrashed()->where('id', $id)->first();
        $c->restore();
       
        if($c->save()):
            return redirect('/admin/ordenescompra/all')->with('message','Restaurada con éxito.')->with('typealert','success');
        endif;
    }
}
