<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Models\Tarea, App\Http\Models\Pieza, App\Http\Models\Categoria;
use Validator,Str,PDF;


class TareasController extends Controller
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
                $input = Tarea::with(['prods','work'])->orderBy('id','desc')->paginate(5); ;
                break;
            case '1':
                $input = Tarea::with(['prods','work'])->where('status','1')->orderBy('id','desc')->paginate(5); ;
                break;
            case '0':
                $input = Tarea::with(['prods','work'])->where('status','0')->orderBy('id','desc')->paginate(5); ;
                break;  
            case 'trash':
                $input = Tarea::with(['prods','work'])->onlyTrashed()->orderBy('id','desc')->paginate(5); 
                break;            
        }
    	  
    	$data = ['input'=> $input];

    	return view('admin.tareas.home', $data);
    }

     public function getTareaAgregar(){
     	$prods = Pieza::where('status','1')->pluck('name','id');
     	$tarea = Categoria::where('seccion','2')->pluck('name','id');
   		$data = ['prods' => $prods, 'tarea'=>$tarea];
        return view('admin.tareas.agregar', $data);
    }

    public function postTareaAgregar(Request $request){
    	$rules =[
            'codigo'=>'required',
            'tarea'=>'required',
            'fecha_programada'=>'required'
        ];

        $messages =[
            'codigo.required'=>'El código es requerido.',
            'tarea.required'=>'Es necesario seleccionar una tarea.',
            'fecha_programada.required'=>'La fecha programada es requerida.'           
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        
        if($validator->fails()):
            return back()->withErrors($validator)->with('message','Se ha producido un error: ')->with('typealert','danger')->withInput();
        else:
           
            $input= new Tarea;
            $input -> status = e($request->input('status'));;
            $input -> codigo = e($request->input('codigo'));
            $input -> tarea_id = e($request->input('tarea'));
            $input -> fecha_prog = e($request->input('fecha_programada'));
            $input -> descripcion = e($request->input('descripcion'));
            $productos = e($request->input('productos'));            
            $productos = html_entity_decode($productos); 
           	$input-> productos = $productos;
           	//disminuye stock
           	$aux = json_decode($productos,true);    

           	if($input-> productos == '0'):
            	return back()->withErrors($validator)->with('message','Debe agregar al menos un item al listado.')->with('typealert','danger')->withInput();            
           	else:
	          	foreach ($aux as $value) {
	          		$p = Pieza::findOrFail($value['id_p']);
					$p-> cantidad -= $value['cantidad'];
					$p->save();
	          	}
	        endif;	
          	//------------------
			
     		if($input->save()):
            	return redirect('/admin/tareas/all')->with('message','Tarea guardada.')->with('typealert','success');
            endif;

        endif;
    }

    public function getTareaEdit($id){
    	$t = Tarea::findOrfail($id);
     	$prods = Pieza::where('status','1')->pluck('name','id');
     	$tarea = Categoria::where('seccion','2')->pluck('name','id');
   		$data = ['prods' => $prods, 'tarea'=>$tarea, 't'=>$t];
        return view('admin.tareas.edit', $data);
    }

    public function postTareaEdit($id, Request $request){
    	           
        $input= Tarea::findOrfail($id);
        $input -> status = e($request->input('status'));;
        $input -> tarea_id = e($request->input('tarea'));
        $input -> descripcion = e($request->input('descripcion'));
       
 		if($input->save()):
        	return redirect('admin/tareas/'.$input->id.'/detalle')->with('message','Se actualizo con éxito.')->with('typealert','success');
        endif;

    }

   	public function getTareaDetalle($id){
   		$t = Tarea::findOrFail($id);
   		$a = json_decode($t->productos,true);
   		$data = ['t' => $t, 'a'=>$a];
   		return view('admin.tareas.detalle', $data);
    }

    public function pdf($id){
    	$t = Tarea::findOrFail($id);
    	$a = json_decode($t->productos,true);
    	$acum = 0;
        $today = Carbon::now()->format('d/m/Y');//fecha actual

        $pdf = PDF::loadView('admin.tareas.pdf',compact('a','t','acum'));

        return $pdf->stream('Detalle_tarea-'.$today.'.pdf');
    
    }

     public function getTareasDelete($id){
        $t= Tarea::findOrfail($id);

        if($t->delete()):
            return back()->with('message','Enviada a la papelera.')->with('typealert','danger');
        endif;
    }

    public function getTareasRestore($id){
        $t= Tarea::onlyTrashed()->where('id', $id)->first();
        $t->restore();
       
        if($t->save()):
            return redirect('/admin/tareas/all')->with('message','Restaurada con éxito.')->with('typealert','success');
        endif;
    }
}
