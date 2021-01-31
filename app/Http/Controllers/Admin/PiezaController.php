<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Models\Categoria, App\Http\Models\Pieza, App\Http\Models\Historia_pieza;
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
        switch ($status) {
            case '0':
                $piezas = Pieza::with(['cat','mark'])->where('status','0')->get();
                break;
             case '1':
                $piezas = Pieza::with(['cat','mark'])->where('status','1')->get();
                break;
            case 'all':
                $piezas = Pieza::with(['cat','mark'])->get();
                break;
            case 'trash':
                $piezas = Pieza::with(['cat','mark'])->onlyTrashed()->get();
                break;
            
        }
        $data = ['piezas' => $piezas];
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
            'cantidad'=>'required',
            'content'=>'max:300'
        ];

        $messages =[
            'name.required'=>'El nombre es requerido',
            'name.max'=>'El nombre debe tener menos de 50 caracteres',
            'cantidad.required'=>'Ingrese una cantidad válida',
            'content.max'=>'Descripción demasiado extensa'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        
        if($validator->fails()):
            return back()->withErrors($validator)->with('message','Se ha producido un error: ')->with('typealert','danger')->withInput();
        else:
            if($request->Hasfile('img')):
                $path = '/'.date('Y-m-d');//Esto es para dar nombre de fecha a la carpeta de imagenes.
                $fileExt = trim($request->file('img')->getClientOriginalExtension());//saca los caracteres del nombre
                $upload_path = Config::get('filesystems.disks.uploads.root');
                $name = Str::slug(str_replace($fileExt, '', $request->file('img')->getClientOriginalName()));//muestra el nombre de la imagen guardada
                $filename = rand(1,999).'-'.$name.'.'.$fileExt;//le pone un numero random al nombre, para que nunca se sobreescriban en las creaciones
               // return $filename;//numerorandom-nombredelarchivoelegido.extension
                
                $final_file = $upload_path.'/'.$path.'/'.$filename;

                if((Categoria::where('seccion', 0)->count() == 0) && (Categoria::where('seccion', 1)->count() == 0)){
                    return back()->withErrors($validator)->with('message','Debe crear al menos 1 categoria y 1 marca.')->with('typealert','danger')->withInput();
                }

                $pieza= new Pieza;
                $pieza -> status = $request->input('status');
                $pieza -> deposito = e($request->input('deposito'));
                $pieza -> name = e($request->input('name'));
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

                if((Categoria::where('seccion', 0)->count() == 0) && (Categoria::where('seccion', 1)->count() == 0)){
                    return back()->withErrors($validator)->with('message','Debe crear al menos 1 categoria y 1 marca.')->with('typealert','danger')->withInput();
                }

                $pieza= new Pieza;
                $pieza -> status = $request->input('status');
                $pieza -> deposito = e($request->input('deposito'));
                $pieza -> name = e($request->input('name'));
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
            $pieza -> name = e($request->input('name'));
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

    // public function postPiezaBuscar(Request $request){
    //     $rules =[
    //         'buscar'=>'required|max:20'
    //     ];

    //     $messages =[
    //         'buscar.required'=>'Es necesario ingresar algo para buscar',
    //         'buscar.max'=>'Búsqueda demasiado extensa'
    //     ];

    //     $validator = Validator::make($request->all(), $rules, $messages);
        
    //     if($validator->fails()):
    //         return redirect('/admin/piezas/1')->withErrors($validator)->with('message','Se ha producido un error: ')->with('typealert','danger')->withInput();
    //     else:
    //         switch ($request->input('filtro')){
    //             case '0':
    //                 $piezas = Pieza::with(['cat','mark'])->where('id',$request->input('buscar'))->orderBy('id','desc')->get();
    //                 break;
    //             case '1':
    //                 $piezas = Pieza::with(['cat','mark'])->where('name','LIKE','%'.$request->input('buscar').'%')->orderBy('id','desc')->get();
    //                 break;
    //             case '2':
    //                 $piezas = Pieza::with(['cat','mark'])->where('codigo','LIKE','%'.$request->input('buscar').'%')->orderBy('id','desc')->get();
    //                 break;   
    //             case '3':
    //                 $piezas = Pieza::with(['cat','mark'])->where('deposito',$request->input('buscar'))->orderBy('id','desc')->get();
    //                 break; 
    //         }

    //         $data = ['piezas' => $piezas];
    //         return view('admin.piezas.buscar', $data);
    //     endif;
    // }

    public function getPiezaDetalle($id){
        $p = Pieza::findOrfail($id);
        $data = ['p'=>$p];

        return view('admin.piezas.detalle', $data);
    }

    public function getPiezaDelete($id){
        $p= Pieza::findOrfail($id);

        if($p->delete()):
            return redirect('/admin/piezas/1')->with('message','Enviado a la papelera.')->with('typealert','danger');
        endif;
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
        
        $piezas = Pieza::all(); 

        $pdf = PDF::loadView('admin.piezas.pdf', compact('piezas'));

        return $pdf->stream('reporte_piezas-'.$today.'.pdf');
    
    }
}
