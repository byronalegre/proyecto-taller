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
        $search = $request->input('search');
        $pag = $request->input('paginate');

        if($pag):
            session(['paginate'=> $pag]);
        else:
            $pag = session('paginate');
        endif;

        if($search){            
            $input = OrdenTrabajo::with(['detalle', 'work', 'user:name,lastname,id'])
                    ->join('users','users.id','=','ordenes_trabajo.responsable_id')
                    ->select('ordenes_trabajo.*','users.name','users.lastname')
                    ->where('users.name','LIKE','%'.$search.'%')
                    ->orWhere('users.lastname','LIKE','%'.$search.'%')
                    ->join('categorias','categorias.id','=','ordenes_trabajo.tarea_id')
                    ->select('ordenes_trabajo.*','categorias.name as tarea')
                    ->orWhere('categorias.name','LIKE','%'.$search.'%')
                    ->orWhere('codigo','LIKE','%'.$search.'%')  
                    // ->orWhere('ordenes_trabajo.created_at','LIKE','%'.date('Y-m-d',strtotime($search)).'%')
                    // ->orWhere('ordenes_trabajo.fecha_prog','LIKE','%'.date('Y-m-d',strtotime($search)).'%')
                    ->orderBy('ordenes_trabajo.id', 'desc')
                    ->paginate($pag);    
        }
        else{
            switch ($status) {
                case 'new':
                    $input = OrdenTrabajo::with(['detalle', 'work', 'user:name,lastname,id'])
                    ->where('status', '0')
                    ->whereDate('created_at','>=', Carbon::now()->startOfMonth()->toDateString())
                    ->orderBy('id','desc')
                    ->paginate($pag); 
                    break;
                case 'all':
                    $input = OrdenTrabajo::with(['detalle', 'work', 'user:name,lastname,id'])
                    ->orderBy('id','desc')
                    ->paginate($pag);
                    break;              
                case '0':
                    $input = OrdenTrabajo::with(['detalle', 'work', 'user:name,lastname,id'])
                    ->where('status','0')
                    ->orderBy('id','desc')
                    ->paginate($pag);
                    break;
                case '1':
                    $input = OrdenTrabajo::with(['detalle', 'work', 'user:name,lastname,id'])
                    ->where('status','1')
                    ->orderBy('id','desc')
                    ->paginate($pag);
                    break;
                case 'trash':
                    $input = OrdenTrabajo::with(['detalle', 'work', 'user:name,lastname,id'])
                    ->onlyTrashed()
                    ->orderBy('id','desc')
                    ->paginate($pag);
                    break;            
            }
        }

    	$data = ['input'=> $input, 'status'=>$status, 'search'=>$search];

    	return view('admin.tareas.home', $data);
    }

     public function getTareaAgregar(){
     	$prods = Pieza::with(['reserve'])->where('status','1')->orderBy('name','asc')->get(['id','name','cantidad', 'cantidad_min']);
     	$tarea = Categoria::where('seccion','2')->orderBy('name','asc')->pluck('name','id');
        $array_r = [];
        
        foreach ($prods as $value) {
            foreach ($value->reserve as $v) {
                array_push($array_r, ['pieza_id'=>$v->pieza_id, 'cantidad_req'=>$v->cantidad_req]);
            }
        }

        for ($i=0;$i<count($array_r);$i++){
            for ($j=$i+1; $j<count($array_r);$j++){
                 if ($array_r[$i]['pieza_id'] == $array_r[$j]['pieza_id']){
                    $array_r[$i]['cantidad_req']= $array_r[$i]['cantidad_req']+$array_r[$j]['cantidad_req'];
                    $array_r[$j]['cantidad_req']=0;
                }            
            }
        }
        
   		$data = ['prods' => $prods, 'tarea'=>$tarea, 'array_r'=>$array_r];
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
        
            if(empty($request->input('productos'))||($request->input('productos') == '[]')):
                return back()->with('message','Debe agregar al menos un item al listado.')->with('typealert','danger');
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
        $t = OrdenTrabajo::with(['detalle'])->findOrfail($id);
        $tarea = Categoria::where('seccion','2')->orderBy('name','asc')->pluck('name','id');
        $prods = Pieza::with(['reserve'])->where('status','1')->orderBy('name','asc')->get(['id','name','cantidad', 'cantidad_min']);
        $array_r = [];
        
        foreach ($prods as $value) {
            foreach ($value->reserve as $v) {
                array_push($array_r, ['pieza_id'=>$v->pieza_id, 'cantidad_req'=>$v->cantidad_req]);
            }
        }

        for ($i=0;$i<count($array_r);$i++){
            for ($j=$i+1; $j<count($array_r);$j++){
                 if ($array_r[$i]['pieza_id'] == $array_r[$j]['pieza_id']){
                    $array_r[$i]['cantidad_req']= $array_r[$i]['cantidad_req']+$array_r[$j]['cantidad_req'];
                    $array_r[$j]['cantidad_req']=0;
                }            
            }
        }

        $data = ['tarea'=>$tarea, 't'=>$t, 'prods'=>$prods, 'array_r'=>$array_r];
        return view('admin.tareas.edit', $data);
    }

    public function postTareaEdit($id, Request $request){
        $rules =[
            'descripcion'=>'max:100'
        ];

        $messages =[
            'descripcion.max'=>'Descripción demasiado extensa.'
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

            if(empty($request->input('productos'))||($request->input('productos') == '[]')):
                return back()->with('message','Debe agregar al menos un item al listado.')->with('typealert','danger');
            else:
                $input -> descripcion = e($request->input('descripcion'));
                
                if($input->save()):                
                    //Detalle
                    $detalle = Detalle_producto::all()->where('orden_id', $id)->where('orden_tipo', 3);

                    foreach($detalle as $item){   
                        $item->forceDelete();       
                    }

                    foreach($aux as $value){
                        $new = new Detalle_producto;
                        $new -> pieza_id = $value['pieza_id'];
                        $new -> precio = 0;
                        $new -> cantidad_usada = 0;
                        $new -> cantidad_req = $value['cantidad'];
                        $new -> orden_tipo = 3;
                        $new -> orden_id = $id;
                        $new->save();
                    }             
                        
                    return redirect('admin/tareas/'.$input->id.'/detalle')->with('message','Se actualizó con éxito.')->with('typealert','success');                    
                endif;

            endif;

        endif;
    }

    public function getTareaComplete($id){
    	$t = OrdenTrabajo::with(['detalle'])->findOrfail($id);
     	$tarea = Categoria::where('seccion','2')->orderBy('name','asc')->pluck('name','id');
        $prods = Pieza::with(['reserve'])->where('status','1')->orderBy('name','asc')->get(['id','name','cantidad']);

        $array_r = [];
        
        foreach ($prods as $value) {
            foreach ($value->reserve as $v) {
                array_push($array_r, ['pieza_id'=>$v->pieza_id, 'cantidad_req'=>$v->cantidad_req]);
            }
        }

        for ($i=0;$i<count($array_r);$i++){
            for ($j=$i+1; $j<count($array_r);$j++){
                 if ($array_r[$i]['pieza_id'] == $array_r[$j]['pieza_id']){
                    $array_r[$i]['cantidad_req'] = $array_r[$i]['cantidad_req'] + $array_r[$j]['cantidad_req'];
                    $array_r[$j]['cantidad_req'] = 0;
                }            
            }
        }

   		$data = ['tarea'=>$tarea, 't'=>$t, 'prods'=>$prods, 'array_r'=>$array_r];
        return view('admin.tareas.complete', $data);
    }

    public function postTareaComplete($id, Request $request){
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

            if(empty($request->input('productos'))||($request->input('productos') == '[]')):
                return back()->with('message','Debe agregar al menos un item al listado.')->with('typealert','danger');
            else:
                $input -> status = 1;
                $input -> descripcion = e($request->input('descripcion'));
                
                if($input->save()):                
                    //Detalle
                    $detalle = Detalle_producto::all()->where('orden_id', $id)->where('orden_tipo', 3);

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
                        foreach($aux as $value){                            
                            $p = Pieza::findOrFail($value['pieza_id']);  
                            $c = Categoria::findOrfail($p->categoria_id);
                            
                            if(!strpos($c->name,'erramienta')):
                                $p-> cantidad -= $value['cantidad'];
                                $p->save();
                            endif;
                        }
                    endif;                        
                    return redirect('admin/tareas/'.$id.'/detalle')->with('message','Se completó con éxito.')->with('typealert','success');                    
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

    public function TareasPdf(){   
        $ot = OrdenTrabajo::orderBy('created_at','desc')->get();

        $today = Carbon::now()->format('d/m/Y');//fecha actual

        $pdf = PDF::loadView('admin.tareas.tareas_pdf',compact('ot'));

        return $pdf->stream('Reporte_tareas-'.$today.'.pdf');
    
    }

    public function TareasMesPdf(){
        $ot = OrdenTrabajo::whereYear('created_at', Carbon::now()->format('Y'))->whereMonth('created_at', Carbon::now()->format('m'))->orderBy('created_at','desc')->get();
        
        $today = Carbon::now()->format('d/m/Y');//fecha actual

        $pdf = PDF::loadView('admin.tareas.tareas_mes_pdf',compact('ot'));

        return $pdf->stream('Reporte_tareas_mes-'.$today.'.pdf');
    }

    public function TareasAnoPdf(){
        $ot = OrdenTrabajo::whereYear('created_at', Carbon::now()->format('Y'))->orderBy('created_at','desc')->get();
        
        $today = Carbon::now()->format('d/m/Y');//fecha actual

        $pdf = PDF::loadView('admin.tareas.tareas_ano_pdf',compact('ot'));

        return $pdf->stream('Reporte_tareas_año'.now()->format('Y').'-'.$today.'.pdf');
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

    public function order($status, $campo, $direc, Request $request){
        $search = $request->input('search');
        $pag = $request->input('paginate');

        if($pag):
            session(['paginate'=> $pag]);
        else:
            $pag = session('paginate');
        endif;

        if($search){            
            $input = OrdenTrabajo::with(['detalle', 'work', 'user:name,lastname,id'])
                    ->join('users','users.id','=','ordenes_trabajo.responsable_id')
                    ->select('ordenes_trabajo.*','users.name','users.lastname')
                    ->where('users.name','LIKE','%'.$search.'%')
                    ->orWhere('users.lastname','LIKE','%'.$search.'%')
                    ->join('categorias','categorias.id','=','ordenes_trabajo.tarea_id')
                    ->select('ordenes_trabajo.*','categorias.name as tarea')
                    ->orWhere('categorias.name','LIKE','%'.$search.'%')
                    ->orWhere('codigo','LIKE','%'.$search.'%')  
                    // ->orWhere('ordenes_trabajo.created_at','LIKE','%'.date('Y-m-d',strtotime($search)).'%')
                    // ->orWhere('ordenes_trabajo.fecha_prog','LIKE','%'.date('Y-m-d',strtotime($search)).'%')
                    ->orderBy('ordenes_trabajo.id', 'desc')
                    ->paginate($pag);    
        }
        else{
            switch ($status) {
                case 'new':
                    $input = OrdenTrabajo::with(['detalle', 'work', 'user:name,lastname,id'])
                    ->where('status', '0')
                    ->whereDate('created_at','>=', Carbon::now()->startOfMonth()->toDateString())
                    ->orderBy($campo, $direc)
                    ->paginate($pag); 
                    break;
                case 'all':
                    $input = OrdenTrabajo::with(['detalle', 'work', 'user:name,lastname,id'])
                    ->orderBy($campo, $direc)
                    ->paginate($pag);
                    break;              
                case '0':
                    $input = OrdenTrabajo::with(['detalle', 'work', 'user:name,lastname,id'])
                    ->where('status','0')
                    ->orderBy($campo, $direc)
                    ->paginate($pag);
                    break;
                case '1':
                    $input = OrdenTrabajo::with(['detalle', 'work', 'user:name,lastname,id'])
                    ->where('status','1')
                    ->orderBy($campo, $direc)
                    ->paginate($pag);
                    break;
                case 'trash':
                    $input = OrdenTrabajo::with(['detalle', 'work', 'user:name,lastname,id'])
                    ->onlyTrashed()
                    ->orderBy($campo, $direc)
                    ->paginate($pag);
                    break;            
            }
        }

    	$data = ['input'=> $input, 'status'=>$status, 'search'=>$search];

    	return view('admin.tareas.home', $data);
    }
}
