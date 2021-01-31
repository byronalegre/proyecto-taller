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
            $provs = Proveedor::all();
        elseif($status == 'trash'): 
            $provs = Proveedor::onlyTrashed()->get();
        endif;
    	
    	$data = ['provs'=> $provs];

    	return view('admin.proveedores.home', $data);
    }

     public function getProveedorAgregar(){
   	
        return view('admin.proveedores.agregar');

    }

    public function postProveedorAgregar(Request $request){
        $rules =[
            'name'=>'required|max:50',
            'cuit'=>'required|digits:11',
            'direccion'=>'required|max:50',
            'telefono'=>'required|digits_between:7,15',
            'correo'=>'required|email|unique:proveedores,correo',

        ];

        $messages =[
            'name.required'=>'El nombre del proveedor es requerido',
            'name.max' => 'El nombre debe tener menos de 50 caracteres',
            'cuit.required'=>'El CUIT es requerido',
            'cuit.digits' => 'El CUIT debe tener 11 digitos',
            'direccion.required'=>'La dirección es requerida',
            'direccion.max' => 'La dirección debe tener menos de 50 caracteres',
            'telefono.required'=>'El teléfono es requerido',
            'telefono.digits_between' => 'El telefono debe ser numérico, tener como mínimo 7 digitos y como máximo 15',
            'correo.required'=>'El correo es requerido',
            'correo.email'=>'El correo es inválido',
            'correo.unique'=>'El correo ya existe'         
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
            'name'=>'required|max:50',
            'cuit'=>'required|max:11',
            'direccion'=>'required|max:50',
            'telefono'=>'required|digits_between:7,15',
            'correo'=>'required|email'

        ];

        $messages =[
            'name.required'=>'El nombre del proveedor es requerido',
            'name.max' => 'El nombre debe tener menos de 50 caracteres',
            'cuit.required'=>'El CUIT es requerido',
            'cuit.max' => 'El CUIT debe tener 10 caracteres',
            'direccion.required'=>'La dirección es requerida',
            'direccion.max' => 'La dirección debe tener menos de 50 caracteres',
            'telefono.required'=>'El teléfono es requerido',
            'telefono.digits_between' => 'El telefono debe ser numérico, tener como mínimo 7 digitos y como máximo 15',
            'correo.required'=>'El correo es requerido',
            'correo.email'=>'El correo es inválido'         
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
       
    //  public function postProveedorBuscar(Request $request){
    //     $rules =[
    //         'buscar'=>'required|max:20'
    //     ];

    //     $messages =[
    //         'buscar.required'=>'Es necesario ingresar algo para buscar',
    //         'buscar.max'=>'Búsqueda demasiado extensa'
    //     ];

    //     $validator = Validator::make($request->all(), $rules, $messages);
        
    //     if($validator->fails()):
    //         return redirect('/admin/proveedores/all')->withErrors($validator)->with('message','Se ha producido un error: ')->with('typealert','danger')->withInput();
    //     else:
    //         switch ($request->input('filtro')){
                
    //             case '0':
    //                 $provs = Proveedor::where('id',$request->input('buscar'))->orderBy('id','desc')->get();
    //                 break;
    //             case '1':
    //                 $provs = Proveedor::where('name','LIKE','%'.$request->input('buscar').'%')->orderBy('id','desc')->get();
    //                 break;
    //             case '2':
    //                 $provs = Proveedor::where('cuit','LIKE','%'.$request->input('buscar').'%')->orderBy('id','desc')->get();
    //                 break;
    //             case '3':
    //                 $provs = Proveedor::where('direccion','LIKE','%'.$request->input('buscar').'%')->orderBy('id','desc')->get();
    //                 break;
    //             case '4':
    //                 $provs = Proveedor::where('telefono','LIKE','%'.$request->input('buscar').'%')->orderBy('id','desc')->get();
    //                 break;
   
    //         }

    //         $data = ['provs' => $provs];
    //         return view('admin.proveedores.buscar', $data);
    //     endif;
    // }

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
