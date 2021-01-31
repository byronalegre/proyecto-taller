<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Models\Pieza, App\Http\Models\Categoria, App\Http\Models\OrdenTrabajo, App\Http\Models\Detalle_producto;
use Validator,Str,PDF,Auth;


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
                $input = OrdenTrabajo::all();
                break;
            case '1':
                $input = OrdenTrabajo::where('status','1')->get();
                break;
            case '0':
                $input = OrdenTrabajo::where('status','0')->get();
                break;  
            case 'trash':
                $input = OrdenTrabajo::onlyTrashed()->get();
                break;            
        }
    	  
    	$data = ['input'=> $input];

    	return view('admin.tareas.home', $data);
    }

     public function getTareaAgregar(){
        $all = Pieza::all();
     	$prods = Pieza::where('status','1')->orderBy('name','asc')->pluck('name','id');
     	$tarea = Categoria::where('seccion','2')->orderBy('name','asc')->pluck('name','id');
   		$data = ['prods' => $prods, 'tarea'=>$tarea, 'all'=>$all];
        return view('admin.tareas.agregar', $data);
    }

    public function postTareaAgregar(Request $request){
    	$rules =[
            'tarea'=>'required',
            'fecha_programada'=>'required',
            'descripcion'=>'max:100'
        ];

        $messages =[
            'tarea.required'=>'Es necesario seleccionar una tarea.',
            'fecha_programada.required'=>'La fecha programada es requerida.',
            'descripcion.max'=>'Descripción demasiado extensa'           
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        
            if(empty($request->input('productos'))):
                return back()->withErrors($validator)->with('message','Debe agregar al menos un item al listado.')->with('typealert','danger')->withInput();
            else:
           
            $input= new OrdenTrabajo;
            $input -> status = 0;
            $input -> responsable_id = Auth::user()->id;
            $input -> codigo = 0;
            $input -> tarea_id = e($request->input('tarea'));
            $input -> fecha_prog = e($request->input('fecha_programada'));
            $input -> descripcion = e($request->input('descripcion'));

            $productos = e($request->input('productos'));            
            $productos = html_entity_decode($productos); 
           	//disminuye stock
           	$aux = json_decode($productos,true);

            if(empty($request->input('productos'))):
                return back()->withErrors($validator)->with('message','Debe agregar al menos un item al listado.')->with('typealert','danger')->withInput();
            else:
                if($input->save())://Guarda
                    foreach($aux as $value){ 
                        //Detalle 
                        $detalle = new Detalle_producto;
                        $detalle -> pieza_id = $value['pieza_id'];
                        $detalle -> precio = 0;
                        $detalle -> cantidad_usada = 0;
                        $detalle -> cantidad_req = $value['cantidad'];
                        $detalle -> orden_tipo = 3; //0-compra 1-remito 2-pedido 3-trabajo
                        $detalle -> orden_id = OrdenTrabajo::all()->last()->id;
                        $detalle->save();                        
                    }
                    //Genera luego de guardar el remito, el codigo
                    $input-> codigo = 'ODT-'.OrdenTrabajo::all()->last()->id;
                    $input->save();

                    return redirect('/admin/tareas/all')->with('message','Tarea guardada.')->with('typealert','success');
                endif;
            endif;    
        endif;
    }

    public function getTareaEdit($id){
        $all = Pieza::all();
    	$t = OrdenTrabajo::with(['detalle'])->findOrfail($id);
     	$tarea = Categoria::where('seccion','2')->pluck('name','id');
        $prods = Pieza::where('status','1')->orderBy('name','asc')->pluck('name','id');

   		$data = ['tarea'=>$tarea, 't'=>$t, 'prods'=>$prods, 'all'=>$all];
        return view('admin.tareas.edit', $data);
    }

    public function postTareaEdit($id, Request $request){
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
                   
            $input= OrdenTrabajo::findOrfail($id);        

            $productos = e($request->input('productos'));
            $productos = html_entity_decode($productos);    
            $aux = json_decode($productos,true);   
           // return $aux;

            if(empty($aux)):
                return back()->withErrors($validator)->with('message','Debe agregar al menos un item al listado.')->with('typealert','danger')->withInput();
            else:
                $input -> status = 1;
                $input -> descripcion = e($request->input('descripcion'));
                if($input->save()):                
                    //Detalle
                    $detalle = Detalle_producto::all()->where('orden_id', $id);

                    foreach($detalle as $item){
                        foreach($aux as $value){
                            if($item->pieza_id == $value['pieza_id']){
                                $item -> cantidad_usada = $value['cantidad'];
                                $item->save();
                            }
                            else
                            {   
                                if(Detalle_producto::where('orden_id', $id)->where('orden_tipo', 3)->where('pieza_id', $value['pieza_id'])->count() == 0){
                                    $new = new Detalle_producto;
                                    $new -> pieza_id = $value['pieza_id'];
                                    $new -> precio = 0;
                                    $new -> cantidad_usada = $value['cantidad'];
                                    $new -> cantidad_req = $value['cantidad'];
                                    $new -> orden_tipo = 3; //0-compra 1-remito 2-pedido 3-trabajo
                                    $new -> orden_id = $id;
                                    $new->save();
                                }                                 
                            }                            
                        }
                    }                        

                    if($input->status == '1'):
                        foreach($detalle as $item){
                            $p = Pieza::findOrFail($item -> pieza_id);
                            $p-> cantidad -= $item -> cantidad_usada;
                            $p->save();
                        }
                    endif;
                        
                    return redirect('admin/tareas/'.$input->id.'/detalle')->with('message','Se actualizó con éxito.')->with('typealert','success');                    
                endif;
            endif;
        endif;
    }

   	public function getTareaDetalle($id){
   		$t = OrdenTrabajo::findOrFail($id);

   		$data = ['t' => $t];
   		return view('admin.tareas.detalle', $data);
    }

    public function pdf($id){
    	$t = OrdenTrabajo::findOrFail($id);
        $today = Carbon::now()->format('d/m/Y');//fecha actual

        $pdf = PDF::loadView('admin.tareas.pdf',compact('t'));

        return $pdf->stream('Detalle_ordentrabajo-'.$today.'.pdf');
    
    }

     public function getTareasDelete($id){
        $t= OrdenTrabajo::with(['detalle'])->findOrfail($id);

        foreach ($t->detalle as $value){

            if($t->status == 1):
                $p = Pieza::findOrFail($value['pieza_id']);
                $p-> cantidad += $value['cantidad_usada'];
                $p->save();
            endif;

            $d = Detalle_producto::where('orden_id', $id)->where('orden_tipo', '3');
            $d->delete();
        }

        if($t->delete()):
            return back()->with('message','Enviada a la papelera.')->with('typealert','danger');
        endif;
    }

    public function getTareasRestore($id){
        $t= OrdenTrabajo::onlyTrashed()->where('id', $id)->first();
        $d = Detalle_producto::onlyTrashed()->where('orden_id', $id)->get();

        $t->restore();
        
        foreach($d as $value){
            $value->restore();
            $value->save();
        }

        if($t->save()):
            $ot = OrdenTrabajo::with(['detalle'])->findOrfail($id);
            
            if($t->status == 1):
                foreach ($ot->detalle as $value){                
                    $p = Pieza::findOrFail($value['pieza_id']);
                    $p-> cantidad -= $value['cantidad_usada'];
                    $p->save();
                }  
            endif;

            return redirect('/admin/tareas/all')->with('message','Restaurada con éxito.')->with('typealert','success');
        endif;
    }
}
