<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Models\Compra, App\Http\Models\Proveedor, App\Http\Models\Pieza, App\Http\Models\OrdenCompra;
use Validator,PDF,Auth;

class ComprasController extends Controller
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
                $input = Compra::with(['provs','prods','orden'])->orderBy('id','desc')->paginate(config('settings.pag'));
                break;
            case 'trash':
                $input = Compra::with(['provs','prods','orden'])->onlyTrashed()->orderBy('id','desc')->paginate(config('settings.pag'));
                break;            
        }
    	  
    	$data = ['input'=> $input];

    	return view('admin.compras.home', $data);
    }

     public function getCompraAgregar(){
   		$provs = Proveedor::all()->pluck('name','id');
   		$prods = Pieza::where('status','1')->pluck('name','id');
        $orden = OrdenCompra::where('status','1')->pluck('codigo','id');
   		$data = ['provs' => $provs,'prods' => $prods, 'orden' => $orden];
        return view('admin.compras.agregar', $data);
    }

    public function postCompraAgregar(Request $request){
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
           
            $input= new Compra;
            $input -> responsable = '['. Auth::user()->id .'] ' . Auth::user()->name .' '. Auth::user()->lastname;
           // $input -> status ='0';
            $input -> orden_id = e($request->input('orden_id'));
            $input -> proveedor_id = e($request->input('proveedor'));
            $input -> codigo = e($request->input('codigo'));
            $input -> descripcion = e($request->input('descripcion'));
            $productos = e($request->input('productos'));
            $productos = html_entity_decode($productos);         			 
			$input-> productos = $productos;  
			//aumenta stock
            $aux = json_decode($productos,true);    

            if($input-> productos == '0'):
                return back()->withErrors($validator)->with('message','Debe agregar al menos un item al listado.')->with('typealert','danger')->withInput();
            else:
                foreach ($aux as $value) {
                    $p = Pieza::findOrFail($value['id_p']);
                    $p-> cantidad += $value['cantidad'];
                    $p->save();
                }   
            endif;
            //------------------ 
            
     		if($input->save()):
            	return redirect('/admin/compras/all')->with('message','Remito guardado.')->with('typealert','success');
            endif;

        endif;
    }

   	public function getCompraDetalle($id){
   		$c = Compra::findOrFail($id);
   		$a = json_decode($c->productos,true);
   		$acum = 0;
   		$data = ['c' => $c, 'a'=>$a, 'acum'=>$acum];
   		return view('admin.compras.detalle', $data);
    }

    public function pdf($id){
    	$c = Compra::findOrFail($id);
    	$a = json_decode($c->productos,true);
    	$acum = 0;
        $today = Carbon::now()->format('d/m/Y');//fecha actual

        $pdf = PDF::loadView('admin.compras.pdf',compact('a','c','acum'));

        return $pdf->stream('Detalle_remito-'.$today.'.pdf');
    
    }

     public function getComprasDelete($id){
        $c= Compra::findOrfail($id);
        $p= json_decode($c->productos, true);

        foreach ($p as $value) {
            $p = Pieza::findOrFail($value['id_p']);
            $p-> cantidad -= $value['cantidad'];
            $p->save();
        }

        if($c->delete()):
            return back()->with('message','Enviado a la papelera.')->with('typealert','danger');
        endif;
    }

    public function getComprasRestore($id){
        $c= Compra::onlyTrashed()->where('id', $id)->first();
        $p= json_decode($c->productos, true);

        foreach ($p as $value) {
            $p = Pieza::findOrFail($value['id_p']);
            $p-> cantidad += $value['cantidad'];
            $p->save();
        }

        $c->restore();
       
        if($c->save()):
            return redirect('/admin/compras/all')->with('message','Restaurado con éxito.')->with('typealert','success');
        endif;
    }
}
