<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Models\Categoria;
use Validator,Str;

class CategoriasController extends Controller
{
     public function __construct(){
    	$this->middleware('auth');
    	$this->middleware('estadoUsuario');
    	$this->middleware('permisosUsuario');
    	$this->middleware('isadmin');

    }

    public function getHome($seccion){//esto se usa para cambiar el orden que muestra las cats
    	$cats = Categoria::where('seccion', $seccion)->orderBy('id','Asc')->get();
    	$data = ['cats'=> $cats];
    	return view('admin.categorias.home', $data);
    }

    public function postCategoriaAgregar(Request $request){
    	$rules = [
    		'name' => 'required|max:50',
    		'seccion' => 'required',
            'descripcion'=> 'max:300'
    	];
    	$messages = [
    		'name.required' => 'Se requiere un nombre para la categoría',
            'name.max' => 'El nombre debe tener menos de 50 caracteres',
    		'seccion.required' => 'Se requiere una sección para la categoría',
            'descripcion.max'=>'Descripción demasiado extensa'
    	];


    	$validator = Validator::make($request->all(), $rules, $messages);
    	
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message','Se ha producido un error: ')->with('typealert','danger');
    	else:

    	$c = new Categoria;
    	$c->seccion = $request->input('seccion');
    	$c->name = e($request->input('name'));
    	$c->slug = Str::slug($request->input('name'));
    	$c->descripcion = e($request->input('descripcion'));

    	if($c->save()):
    		return back()->with('message','Guardado correctamente.')->with('typealert','success');
    	endif;
    endif;
    }

    public function getCategoriaEdit($id){
    	$cat = Categoria::findOrFail($id);
    	$data = ['cat'=>$cat];
    	return view('admin.categorias.edit', $data);

    }

     public function postCategoriaEdit(Request $request, $id){
    	$rules = [
    		'name' => 'required|max:50',
    		'seccion' => 'required',
            'descripcion'=> 'max:300'
    	];
    	$messages = [
    		'name.required' => 'Se requiere un nombre para la categoría',
            'name.max' => 'El nombre debe tener menos de 50 caracteres',
    		'seccion.required' => 'Se requiere una sección para la categoría',
            'descripcion.max'=>'Descripción demasiado extensa'
    	];


    	$validator = Validator::make($request->all(), $rules, $messages);
    	
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message','Se ha producido un error: ')->with('typealert','danger');
    	else:

    	$c = Categoria::findOrFail($id);
    	$c->seccion = $request->input('seccion');
    	$c->name = e($request->input('name'));
    	//$c->slug = Str::slug($request->input('name'));
    	$c->descripcion = e($request->input('descripcion'));

    	if($c->save()):
    		return redirect('admin/categorias/0')->with('message','Actualizada correctamente.')->with('typealert','success');
    	endif;
    endif;
    }

    public function getCategoriaDelete($id){
    	$c = Categoria::findOrFail($id);

    	if($c->delete()):
    		return back()->with('message','Borrado correctamente.')->with('typealert','success');
    	endif;
    }
}
