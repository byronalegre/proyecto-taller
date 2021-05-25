<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Models\Categoria, App\Http\Models\Pieza, App\Http\Models\Historia_pieza, App\Http\Models\Detalle_producto;
use Validator,Str,Config,Image,PDF,Auth;

class PiezaController extends Controller
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
            $piezas = Pieza::with(['cat:name,id','mark:name,id','reserve'])
            ->join('categorias','categorias.id','=','piezas.categoria_id')
            ->select('piezas.*','categorias.name as category')
            ->where('categorias.name','LIKE','%'.$search.'%')
            ->orWhere('piezas.name','LIKE','%'.$search.'%')
            ->orWhere('codigo','LIKE','%'.$search.'%')
            ->orWhere('cantidad','LIKE','%'.$search.'%')
            ->orderBy('piezas.name', 'asc')
            ->paginate($pag);
        }
        else{
              switch ($status) {
                case '0':
                    $piezas = Pieza::with(['cat:name,id','mark:name,id','reserve'])->where('status','0')->orderBy('name', 'asc')->paginate($pag);
                    break;
                case '1':
                    $piezas = Pieza::with(['cat:name,id','mark:name,id','reserve'])->where('status','1')->orderBy('name', 'asc')->paginate($pag);
                    break;
                case 'all':
                    $piezas = Pieza::with(['cat:name,id','mark:name,id','reserve'])->orderBy('name', 'asc')->paginate($pag);
                    break;
                case 'trash':
                    $piezas = Pieza::with(['cat:name,id','mark:name,id','reserve'])->onlyTrashed()->orderBy('name', 'asc')->paginate($pag);
                    break;
            }            
        }        
        
        $aux = [];
        
        foreach ($piezas as $value) {
            foreach ($value->reserve as $v) {
                array_push($aux, ['pieza_id'=>$v->pieza_id, 'cantidad_req'=>$v->cantidad_req]);
            }
        }

        for ($i=0;$i<count($aux);$i++){
            for ($j=$i+1; $j<count($aux);$j++){
                 if ($aux[$i]['pieza_id'] == $aux[$j]['pieza_id']){
                    $aux[$i]['cantidad_req']= $aux[$i]['cantidad_req']+$aux[$j]['cantidad_req'];
                    $aux[$j]['cantidad_req']=0;
                }            
            }
        }

        $data = ['piezas' => $piezas, 'aux' => $aux, 'status' => $status, 'search' => $search];
    	return view('admin.piezas.home', $data);
    }

    public function getPiezaAgregar(){        
        $cats = Categoria::where('seccion','0')->orderBy('name','asc')->pluck('name','id');
    	$marca = Categoria::where('seccion','1')->orderBy('name','asc')->pluck('name','id');
        $data = ['cats' => $cats,'marca' => $marca];
        return view('admin.piezas.agregar', $data);

    }

    public function postPiezaAgregar(Request $request){
        $rules =[
            'name'=>'required|max:50',
            'cantidad-min'=>'required|max:11',
            'cantidad'=>'required|max:11',            
            'content'=>'max:300'
        ];

        $messages =[
            'name.required'=>'El nombre es requerido',
            'name.max'=>'El nombre debe tener menos de 50 caracteres',
            'cantidad-min.required'=>'Ingrese una cantidad mínima válida',
            'cantidad-min.max'=>'La cantidad mínima no debe superar las 11 cifras.',
            'cantidad.required'=>'Ingrese una cantidad válida',
            'cantidad.max'=>'La cantidad no debe superar las 11 cifras.',            
            'content.max'=>'Descripción demasiado extensa'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()):
            return back()->withErrors($validator)->with('message','Se ha producido un error: ')->with('typealert','danger')->withInput();
        else:

            if((Categoria::where('seccion', 0)->count() == 0) && (Categoria::where('seccion', 1)->count() == 0)):
                return back()->withErrors($validator)->with('message','Debe crear al menos una categoria y una marca.')->with('typealert','danger')->withInput();
            endif;

            if((!$request->input('categoria')) || (!$request->input('marca'))):
                 return back()->withErrors($validator)->with('message','Categoría y/o Marca no pueden estar vacíos. Debe crear al menos una categoría y una marca.')->with('typealert','danger');
            endif;

            if($request->hasfile('img')):
                $path = '/'.date('Y-m-d');//Esto es para dar nombre de fecha a la carpeta de imagenes.
                $fileExt = trim($request->file('img')->getClientOriginalExtension());//saca los caracteres del nombre
                $upload_path = Config::get('filesystems.disks.uploads.root');
                $name = Str::slug(str_replace($fileExt, '', $request->file('img')->getClientOriginalName()));//muestra el nombre de la imagen guardada
                $filename = rand(1,999).'-'.$name.'.'.$fileExt;//le pone un numero random al nombre, para que nunca se sobreescriban en las creaciones
               // return $filename;//numerorandom-nombredelarchivoelegido.extension
                
                $final_file = $upload_path.'/'.$path.'/'.$filename;

                $pieza= new Pieza;
                $pieza -> status = $request->input('status');
                $pieza -> deposito = e($request->input('deposito'));
                $pieza -> name = e(mb_strtoupper($request->input('name'), 'UTF-8'));
                $pieza -> codigo = strtoupper(implode('', array_map(function($v) { return $v[0]; }, explode(' ', $request->input('name'))))).'-'.rand(1,999);
                $pieza -> slug = Str::slug($request->input('name'));
                $pieza -> categoria_id = $request->input('categoria');
                $pieza -> file_path = date('Y-m-d');
                $pieza -> image = $filename;
                $pieza -> cantidad =  e($request->input('cantidad'));
                $pieza -> cantidad_min =  e($request->input('cantidad-min'));            
                $pieza -> marca = $request->input('marca');
                $pieza -> content = e($request->input('content'));

                if($pieza->save()):
                    if($request->hasFile('img')):
                        $fl = $request->img->storeAs($path, $filename, 'uploads');//metodo para guardar archivos
                        $img = Image::make($final_file);
                        $img->resize(256, 256, function($constraint){
                            $constraint->upsize();
                        });
                        $img->save($upload_path.'/'.$path.'/t_'.$filename);
                    endif;

                    return redirect('/admin/piezas/1')->with('message','Guardado correctamente.')->with('typealert','success');
                endif;

            else:

                $pieza= new Pieza;
                $pieza -> status = $request->input('status');
                $pieza -> deposito = e($request->input('deposito'));
                $pieza -> name = e(mb_strtoupper($request->input('name'), 'UTF-8'));
                $pieza -> codigo = strtoupper(implode('', array_map(function($v) { return $v[0]; }, explode(' ', $request->input('name'))))).'-'.rand(1,999);
                $pieza -> slug = Str::slug($request->input('name'));
                $pieza -> categoria_id = $request->input('categoria');
                $pieza -> file_path = 'default';
                $pieza -> image = 'default.png';
                $pieza -> cantidad =  e($request->input('cantidad'));
                $pieza -> cantidad_min =  e($request->input('cantidad-min'));            
                $pieza -> marca = $request->input('marca');
                $pieza -> content = e($request->input('content'));

                if($pieza->save()):
                    return redirect('/admin/piezas/1')->with('message','Guardado correctamente.')->with('typealert','success');
                endif;
            endif;       
        endif;
    }

    public function getPiezaEdit($id){
        $p = Pieza::findOrfail($id);
        $cats = Categoria::where('seccion','0')->pluck('name','id');
        $marca = Categoria::where('seccion','1')->pluck('name','id');
        $data = ['cats' => $cats, 'marca' => $marca, 'p'=>$p];
        return view('admin.piezas.edit', $data);
    }

    public function postPiezaEdit($id, Request $request){
        $rules =[
            'name'=>'required|max:50',
            'cantidad'=>'required',
            'content'=> 'max:300'
        ];

        $messages =[
            'name.required'=>'El nombre es requerido',
            'name.max'=>'El nombre debe tener menos de 50 caracteres',   
            'img.imagen'=>'Seleccione una imagen válida',
            'cantidad.required'=>'Ingrese una cantidad válida',
            'content.max'=>'Descripción demasiado extensa'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        
        if($validator->fails()):
            return back()->withErrors($validator)->with('message','Se ha producido un error: ')->with('typealert','danger')->withInput();
        else:
           
            $pieza= Pieza::findOrfail($id);
            $imgpp= $pieza->file_path;
            $imgprev= $pieza->image;
            $pieza -> status = $request->input('status');
            $pieza -> deposito = e($request->input('deposito'));
            $pieza -> name = e(mb_strtoupper($request->input('name'), 'UTF-8'));
            if($pieza -> isDirty('name')):
                $pieza -> codigo = strtoupper(implode('', array_map(function($v) { return $v[0]; }, explode(' ', $request->input('name'))))).'-'.rand(1,999);   
            endif;         
          //  $pieza -> slug = Str::slug($request->input('name'));
            $pieza -> categoria_id = $request->input('categoria');

            if($request->hasFile('img')):
                $path = '/'.date('Y-m-d');//Esto es para dar nombre de fecha a la carpeta de imagenes.
                $fileExt = trim($request->file('img')->getClientOriginalExtension());//saca los caracteres del nombre
                $upload_path = Config::get('filesystems.disks.uploads.root');
                $name = Str::slug(str_replace($fileExt, '', $request->file('img')->getClientOriginalName()));//muestra el nombre de la imagen guardada
                $filename = rand(1,999).'-'.$name.'.'.$fileExt;//le pone un numero random al nombre, para que nunca se sobreescriban en las creaciones
               // return $filename;//numerorandom-nombredelarchivoelegido.extension
                
                $final_file = $upload_path.'/'.$path.'/'.$filename;

                $pieza -> file_path = date('Y-m-d');
                $pieza -> image = $filename;
            endif;
            $aux = 0;
            $old = 0;
            $pieza -> cantidad = e($request->input('cantidad'));
            $pieza -> cantidad_min = e($request->input('cantidad-min'));
            $pieza -> marca = $request->input('marca');
            $pieza -> content = e($request->input('content'));

            $old = json_encode($pieza->getOriginal());

            if($pieza->isDirty()):
                $aux = json_encode($pieza->getDirty());                
            endif;

            if($pieza->save()):
                if($request->hasFile('img')):
                    $fl = $request->img->storeAs($path, $filename, 'uploads');//metodo para guardar archivos
                    $img = Image::make($final_file);
                    $img->resize(256, 256, function($constraint){
                        $constraint->upsize();
                    });
                    $img->save($upload_path.'/'.$path.'/t_'.$filename);
                    unlink($upload_path.'/'.$imgpp.'/'.$imgprev);
                    unlink($upload_path.'/'.$imgpp.'/t_'.$imgprev);
                endif;

                $log = new Historia_pieza;
                $log-> pieza_id = $id;
                $log-> responsable_id = Auth::user()->id;
                $log-> old_values = $old;
                $log-> new_values = $aux;
                $log->save();

                return redirect('/admin/piezas/all')->with('message','Actualizado correctamente.')->with('typealert','success');
            endif;
       
        endif;
    }

    public function getPiezaDetalle($id){
        $p = Pieza::findOrfail($id);
        $data = ['p'=>$p];

        return view('admin.piezas.detalle', $data);
    }

    public function getPiezaDelete($id){
        $p= Pieza::findOrfail($id);
        $cont = Detalle_producto::where('pieza_id', $id)->count();

        if($cont != 0)
        {
             return back()->with('message','No se puede Eliminar. Hay '.$cont. ' elemento/s relacionado/s con esta pieza.')->with('typealert','danger');
        }
        else
        {
            if($p->delete()):
                return redirect('/admin/piezas/1')->with('message','Enviado a la papelera.')->with('typealert','danger');
            endif;
        }
    }

    public function getPiezaRestore($id){
        $p= Pieza::onlyTrashed()->where('id', $id)->first();
        $p->restore();
       
        if($p->save()):
            return redirect('/admin/piezas/'.$p->id.'/edit')->with('message','Restaurado con éxito.')->with('typealert','success');
        endif;
    }

    public function pdf(){
        $today = Carbon::now()->format('d/m/Y');//fecha actual
        
        $piezas = Pieza::where('status', 1)->orderBy('name','asc')->get(); 

        $pdf = PDF::loadView('admin.piezas.pdf', compact('piezas'));

        return $pdf->stream('reporte_piezas-'.$today.'.pdf');
    
    }

    public function pdfStock(){
        $today = Carbon::now()->format('d/m/Y');//fecha actual
        $piezas_stock_min=0;
        $piezas_stock_normal=0;
        $piezas_sin_stock=0;
        $piezas = Pieza::where('status', 1)->orderBy('name','asc')->get(); 

        foreach($piezas as $p){
            if($p->cantidad < $p->cantidad_min){
                $piezas_stock_min ++;
            }
            if($p->cantidad >= $p->cantidad_min){
                $piezas_stock_normal ++;
            }
            if($p->cantidad == 0){
                $piezas_sin_stock ++;
            }
        }

        $pdf = PDF::loadView('admin.piezas.pdf-stock', compact('piezas','piezas_stock_min','piezas_stock_normal','piezas_sin_stock'));

        return $pdf->stream('reporte_stock_piezas-'.$today.'.pdf');
    }

    public function order($status, $campo, $direc, Request $request)
    {
        $pag = $request->input('paginate');
        $search = $request->input('search');
        
        if($pag):
            session(['paginate'=> $pag]);
        else:
            $pag = session('paginate');
        endif;

        if($search){
            $piezas = Pieza::with(['cat:name,id','mark:name,id','reserve'])
            ->join('categorias','categorias.id','=','piezas.categoria_id')
            ->select('piezas.*','categorias.name as category')
            ->where('categorias.name','LIKE','%'.$search.'%')
            ->orWhere('piezas.name','LIKE','%'.$search.'%')
            ->orWhere('codigo','LIKE','%'.$search.'%')
            ->orWhere('cantidad','LIKE','%'.$search.'%')
            ->orderBy('piezas.name', 'asc')
            ->paginate($pag);
        }
        else{
            switch ($status) {
                case '0':
                    $piezas = Pieza::with(['cat:name,id','mark:name,id','reserve'])->where('status','0')->orderBy($campo, $direc)->paginate($pag);
                    break;
                case '1':
                    $piezas = Pieza::with(['cat:name,id','mark:name,id','reserve'])->where('status','1')->orderBy($campo, $direc)->paginate($pag);
                    break;
                case 'all':
                    $piezas = Pieza::with(['cat:name,id','mark:name,id','reserve'])->orderBy($campo, $direc)->paginate($pag);
                    break;
                case 'trash':
                    $piezas = Pieza::with(['cat:name,id','mark:name,id','reserve'])->onlyTrashed()->orderBy($campo, $direc)->paginate($pag);
                    break;
            }
        }
        $aux = [];
        
        foreach ($piezas as $value) {
            foreach ($value->reserve as $v) {
                array_push($aux, ['pieza_id'=>$v->pieza_id, 'cantidad_req'=>$v->cantidad_req]);
            }
        }

        for ($i=0;$i<count($aux);$i++){
            for ($j=$i+1; $j<count($aux);$j++){
                 if ($aux[$i]['pieza_id'] == $aux[$j]['pieza_id']){
                    $aux[$i]['cantidad_req']= $aux[$i]['cantidad_req']+$aux[$j]['cantidad_req'];
                    $aux[$j]['cantidad_req']=0;
                }            
            }
        }

        $data = ['piezas' => $piezas, 'aux' => $aux, 'status' => $status, 'search'=>$search];
    	return view('admin.piezas.home', $data);
    }
}
