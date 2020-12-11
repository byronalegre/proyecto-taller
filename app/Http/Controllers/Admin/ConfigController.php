<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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

    public function postHome(Request $Request){
    	if(file_exists(config_path().'/settings.php')):
    		fopen(config_path().'/settings.php', 'w');
    	endif;

    	$file = fopen(config_path().'/settings.php', 'w');
    	fwrite($file, '<?php'.PHP_EOL);
    	fwrite($file, 'return ['.PHP_EOL);

    	foreach ($Request->except(['_token']) as $key => $value) :
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
    }
}
