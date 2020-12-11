<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Models\Proveedor;
use Validator,Str,PDF;

class ProveedoresController extends Controller
{
     public function __construct(){
    	$this->middleware('auth');
    	$this->middleware('estadoUsuario');
    	$this->middleware('permisosUsuario');
    	$this->middleware('isadmin');

    }

    public function getHome($status){
    	if($status == 'all'):
            $provs = Proveedor::orderBy('id','Desc')->paginate(config('settings.pag'));    
        elseif($status == 'trash'): 
            $provs = Proveedor::onlyTrashed()->orderBy('id','desc')->paginate(config('settings.pag'));
        endif;
    	
    	$data = ['provs'=> $provs];

    	return view('admin.proveedores.home', $data);
    }

     public function getProveedorAgregar(){
   	
        return view('admin.proveedores.agregar');

    }

    public function postProveedorAgregar(Request $request){
        $rules =[
            'name'=>'required',
            'cuit'=>'required',
            'direccion'=>'required',
            'telefono'=>'required',
            'correo'=>'required'

        ];

        $messages =[
            'name.required'=>'El nombre del proveedor es requerido.',
            'cuit.required'=>'El CUIT es requerido',
            'direccion.required'=>'La dirección es requerida.',
            'telefono.required'=>'El teléfono es requerido.',
            'correo.required'=>'El correo es requerido'         
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        
        if($validator->fails()):
            return back()->withErrors($validator)->with('message','Se ha producido un error: ')->with('typealert','danger')->withInput();
        else:
           
            $provs= new Proveedor;
            $provs -> name = e($request->input('name'));
            $provs -> cuit = e($request->input('cuit'));            
            $provs -> direccion =  e($request->input('direccion'));
            $provs -> telefono = e($request->input('telefono'));
            $provs -> correo =  e($request->input('correo'));
            $provs -> slug = Str::slug($request->input('name'));

     		if($provs->save()):
            	return redirect('/admin/proveedores/all')->with('message','Guardado correctamente.')->with('typealert','success');
        
            endif;

        endif;
    }

    public function getProveedorEdit($id){
    	$prov = Proveedor::findOrFail($id);
    	$data = ['prov'=>$prov];
    	return view('admin.proveedores.edit', $data);

    }

     public function postProveedorEdit(Request $request, $id){
        $rules =[
            'name'=>'required',
            'cuit'=>'required',
            'direccion'=>'required',
            'telefono'=>'required',
            'correo'=>'required'

        ];

        $messages =[
            'name.required'=>'El nombre del proveedor es requerido.',
            'cuit.required'=>'El CUIT es requerido',
            'direccion.required'=>'La dirección es requerida.',
            'telefono.required'=>'El teléfono es requerido.',
            'correo.required'=>'El correo es requerido'         
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        
        if($validator->fails()):
            return back()->withErrors($validator)->with('message','Se ha producido un error: ')->with('typealert','danger')->withInput();
        else:
           
            $provs= Proveedor::findOrFail($id);
            $provs -> name = e($request->input('name'));
            $provs -> cuit = e($request->input('cuit'));            
            $provs -> direccion =  e($request->input('direccion'));
            $provs -> telefono = e($request->input('telefono'));
            $provs -> correo =  e($request->input('correo'));

     		if($provs->save()):
            	return back()->with('message','Actualizado correctamente.')->with('typealert','success');
        
            endif;

        endif;
    }   
       
     public function postProveedorBuscar(Request $request){
        $rules =[
            'buscar'=>'required'
        ];

        $messages =[
            'buscar.required'=>'Es necesario ingresar algo para buscar.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        
        if($validator->fails()):
            return redirect('/admin/proveedores/all')->withErrors($validator)->with('message','Se ha producido un error: ')->with('typealert','danger')->withInput();
        else:
            switch ($request->input('filtro')){
                
                case '0':
                    $provs = Proveedor::where('id',$request->input('buscar'))->orderBy('id','desc')->get();
                    break;
                case '1':
                    $provs = Proveedor::where('name','LIKE','%'.$request->input('buscar').'%')->orderBy('id','desc')->get();
                    break;
                case '2':
                    $provs = Proveedor::where('cuit',$request->input('buscar'))->orderBy('id','desc')->get();
                    break;
                case '3':
                    $provs = Proveedor::where('direccion','LIKE','%'.$request->input('buscar').'%')->orderBy('id','desc')->get();
                    break;
                case '4':
                    $provs = Proveedor::where('telefono',$request->input('buscar'))->orderBy('id','desc')->get();
                    break;
   
            }

            $data = ['provs' => $provs];
            return view('admin.proveedores.buscar', $data);
        endif;
    }

    public function getProveedorDelete($id){
    	$c = Proveedor::findOrFail($id);

    	if($c->delete()):
    		return redirect('/admin/proveedores/all')->with('message','Enviado a la papelera.')->with('typealert','danger');
    	endif;
    }
       
    public function getProveedorRestore($id){
        $p= Proveedor::onlyTrashed()->where('id', $id)->first();
        $p->restore();
       
        if($p->save()):
            return redirect('/admin/proveedores/'.$p->id.'/edit')->with('message','Restaurado con éxito.')->with('typealert','success');
        endif;
    }
     public function pdf(){
        $today = Carbon::now()->format('d/m/Y');//fecha actual
        
        $provs = Proveedor::all(); 

        $pdf = PDF::loadView('admin.proveedores.pdf', compact('provs'));

        return $pdf->stream('reporte_proveedores-'.$today.'.pdf');
    
    }
}
