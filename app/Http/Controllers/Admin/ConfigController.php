<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
class ConfigController extends Controller
{
    public function __construct(){
    	$this->middleware('auth');
    	$this->middleware('estadoUsuario');
    	$this->middleware('permisosUsuario');
    	$this->middleware('isadmin');

    }

    public function getHome(){
    	return view('admin.config.config');
    }

    public function postHome(Request $request){
        $rules =[
            'name'=>'required|max:20',
            'telefono'=>'max:10',
            'direccion'=>'max:50'
        ];

        $messages =[
            'name.required'=>'El nombre es requerido',
            'name.max'=>'El nombre debe tener menos de 20 caracteres',
            'telefono.max'=>'El telefono puede tener hasta 8 caracteres',
            'direccion.max'=>'La dirección puede tener hasta 50 caracteres.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        
        if($validator->fails()):
            return back()->withErrors($validator)->with('message','Se ha producido un error: ')->with('typealert','danger')->withInput();
        else:

            // if(is_null($request->input('logo'))):
            //     return back()->with('message','Seleccione una imagen antes de Guardar')->with('typealert','danger')->withInput();
            // endif;

        	if(file_exists(config_path().'/settings.php')):
        		fopen(config_path().'/settings.php', 'w');
        	endif;

        	$file = fopen(config_path().'/settings.php', 'w');
        	fwrite($file, '<?php'.PHP_EOL);
        	fwrite($file, 'return ['.PHP_EOL);

        	foreach ($request->except(['_token']) as $key => $value) :
        		if(is_null($value)):
        			fwrite($file, '\''.$key.'\' => \'\',' .PHP_EOL);
        		else:
        			fwrite($file, '\''.$key.'\' => \''.$value.'\',' .PHP_EOL);
        		endif;
        	endforeach;


        	fwrite($file, ']'.PHP_EOL );
        	fwrite($file, '?>'.PHP_EOL );
        	fclose($file);

        	return back()->with('message','Configuración actualizada con éxito.')->with('typealert','success')->withInput();
        endif;
    }
}
