<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Validator,Auth,Hash,Mail;
use App\Mail\EnvioNuevoUsuarioyContraseña;
class UsuariosController extends Controller
{
     public function __construct(){
    	$this->middleware('auth');
    	$this->middleware('estadoUsuario');
    	$this->middleware('permisosUsuario');
    	$this->middleware('isadmin');

    }

    public function getUsuarios($status){
    	if($status == 'all'):
    		$users= User::orderBy('id','Desc')->paginate(config('settings.pag'));
    	else:
    		$users= User::where('status', $status)->orderBy('id','Desc')->paginate(config('settings.pag'));
    	endif;

    	$data= ['users'=> $users];
    	return view('admin.usuarios.home', $data);
    }

    public function getUsuarioEdit($id){
    	$u = User::findOrFail($id);
    	$data = ['u' => $u];
    	return view('admin.usuarios.edit', $data);
    }

    public function postUsuarioEdit(Request $request, $id){
        $u = User::findOrFail($id);
        $u->role = $request->input('rol_user');

        //Se encuentran predeterminados los permisos por ROL.
        //Si es 1 (ADMIN)- tendra permiso a todo
        //Si es 2 (E. DEPOSITO)- solo podra realizar acciones relacionadas a piezas(A-M), categorias(A-M), tareas(A-M), backup
        //Si es 3 (E. COMPRAS)- solo podra realizar acciones relacionadas a proveedores(A-M), compras(A-M), backup 
        //Si es 4 (E. TAREAS)-
            if($request->input('rol_user') == "1"):  
                $u->permisos = null;         
                if(is_null($u->permisos)):
                    $permisos = [
                        "inicio"=>true,
                        "estadisticas_rapidas"=>true,
                        "e_tareas"=>true, "e_compras"=>true,                    
                        "graficos"=>true,
                        "piezas"=>true, "piezas_agregar"=>true, "piezas_editar"=>true, "piezas_eliminar"=>true, "piezas_buscar"=>true, "piezas_pdf"=>true,  
                        "categorias"=>true, "categorias_agregar"=>true,"categorias_editar"=>true,"categorias_eliminar"=>true, 
                        "usuarios_list"=>true, "usuarios_editar"=>true, "usuarios_suspend"=>true, "usuarios_permisos"=>true, "usuarios_buscar"=>true, "usuarios_register"=>true,
                        "micuenta_editar"=>true, "micuenta_password"=>true, "micuenta_info"=>true,
                        "proveedores"=>true, "proveedores_agregar"=>true, "proveedores_editar"=>true, "proveedores_eliminar"=>true, "proveedores_buscar"=>true, "proveedores_pdf"=>true,
                        "compras"=>true, "compras_agregar"=>true, "compras_eliminar"=>true, "compra_detalle"=>true, "detalle_compra_pdf"=>true,
                        "pedidos"=>true, "pedidos_agregar"=>true, "pedidos_editar"=>true,
                        "backup"=>true, "backup_create"=>true, "backup_dowload"=>true , "backup_delete"=>true,
                        "config"=>true
                    ];
                $permisos = json_encode($permisos);
                $u->permisos = $permisos;   
                endif;          
            endif;

            if ($request->input('rol_user') == "2"):
                $u->permisos = null;
                if(is_null($u->permisos)):
                    $permisos = [
                        "inicio"=>true,
                        "estadisticas_rapidas"=>true,
                        "e_tareas"=>true,                    
                        "graficos"=>true,
                        "piezas"=>true, "piezas_agregar"=>true, "piezas_editar"=>true, "piezas_buscar"=>true, "piezas_pdf"=>true,  
                        "categorias"=>true, "categorias_agregar"=>true,"categorias_editar"=>true,                         
                        "micuenta_editar"=>true, "micuenta_password"=>true, "micuenta_info"=>true,
                        "tareas"=>true, "tareas_agregar"=>true, "tareas_editar"=>true, "tarea_detalle"=>true, "detalle_tarea_pdf"=>true,
                        "backup"=>true, "backup_create"=>true
                    ];
                $permisos = json_encode($permisos);
                $u->permisos = $permisos;
                endif;
            endif;            

            if ($request->input('rol_user') == "3"):
                $u->permisos = null;
                if(is_null($u->permisos)):
                    $permisos = [
                        "inicio"=>true,
                        "estadisticas_rapidas"=>true,
                        "e_compras"=>true,                    
                        "graficos"=>true,
                        "piezas"=>true, "piezas_buscar"=>true, "piezas_pdf"=>true,  
                        "micuenta_editar"=>true, "micuenta_password"=>true, "micuenta_info"=>true,
                        "proveedores"=>true, "proveedores_agregar"=>true, "proveedores_editar"=>true, "proveedores_buscar"=>true, "proveedores_pdf"=>true,
                        "compras"=>true, "compras_agregar"=>true, "compra_detalle"=>true, "detalle_compra_pdf"=>true,
                        "backup"=>true, "backup_create"=>true
                    ];
                $permisos = json_encode($permisos);
                $u->permisos = $permisos;
                endif;                  
            endif;   

            if ($request->input('rol_user') == "4"):
                $u->permisos = null;
                if(is_null($u->permisos)):
                    $permisos = [
                        "inicio"=>true,
                        "estadisticas_rapidas"=>true,
                        "piezas"=>true, "piezas_buscar"=>true, "piezas_pdf"=>true, 
                        "e_tareas"=>true,                    
                        "graficos"=>true,                         
                        "micuenta_editar"=>true, "micuenta_password"=>true, "micuenta_info"=>true,
                        "tareas"=>true, "tareas_agregar"=>true, "tareas_editar"=>true, "tareas_eliminar"=>true, "tarea_detalle"=>true, "detalle_tarea_pdf"=>true,       
                        "backup"=>true, "backup_create"=>true               
                        
                    ];
                $permisos = json_encode($permisos);
                $u->permisos = $permisos;
                endif;                  
            endif;

            if ($request->input('rol_user') == "0"):
                $u->permisos = null;
            endif;  

        if($u->save()):
            if($request->input('rol_user') == "0"): 
                return back()->with('message', 'El rol del usuario se actualizo con éxito.')->with('typealert', 'success');
            else:               
                return redirect('admin/usuarios/'.$u->id.'/permisos')->with('message', 'El rol del usuario se actualizo con éxito.')->with('typealert', 'success');
            endif;
        endif;
    }

    public function getUsuarioSuspend($id){
    	$u = User::findOrFail($id);

    	if($u->status == '100'):
    		$u->status = '1';
    		$msg = 'Usuario activado.';

    	else:
    		$u->status = '100';
    		$msg = 'Usuario suspendido.';
    	endif;

    	if($u->save()):
    		return back()->with('message', $msg)->with('typealert', 'success');
    	endif;

    }

    public function getUsuarioPermisos($id){
    	$u = User::findOrFail($id);
    	$data =['u'=>$u];
    	return view('admin.usuarios.permisos', $data);
    }

    public function postUsuarioPermisos(Request $request, $id){
        
    	$u = User::findOrFail($id);
    	$u->permisos = $request->except(['_token']);
    	if($u->save()):
    		return back()->with('message', 'Los permisos fueron actualizados.')->with('typealert', 'success');
    	endif;
    }

    public function postUsuarioBuscar(Request $request){
         $rules =[
            'buscar'=>'required'
        ];

        $messages =[
            'buscar.required'=>'Es necesario ingresar algo para buscar.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        
        if($validator->fails()):
            return redirect('/admin/usuarios/all')->withErrors($validator)->with('message','Se ha producido un error: ')->with('typealert','danger')->withInput();
        else:
            switch ($request->input('filtro')){
                case '0':
                    $users = User::where('id',$request->input('buscar'))->orderBy('id','desc')->get();
                    break;
                case '1':
                    $users = User::where('name','LIKE','%'.$request->input('buscar').'%')->orderBy('id','desc')->get();
                    break;
                case '2':
                    $users = User::where('lastname','LIKE','%'.$request->input('buscar').'%')->orderBy('id','desc')->get();
                    break;   
            }

            $data = ['users' => $users];
            return view('admin.usuarios.buscar', $data);
        endif;
    }

    public function getMiCuentaEdit(){
        return view('admin.cuenta.edit');
    }

    public function postMiCuentaPassword(Request $request){
        $rules = [        
            'old_password' => 'required|min:8',
            'password' => 'required|min:8',
            'cpassword' => 'required|min:8|same:password'
        ];

        $messages = [
            'old_password.required'=> 'Por favor escriba su contraseña actual.',
            'old_password.min'=> 'Debe tener al menos 8 caracteres',
            'password.required'=> 'Por favor escriba su nueva contraseña',
            'password.min'=> 'Debe tener al menos 8 caracteres',
            'cpassword.required'=> 'Confirme su nueva contraseña',
            'cpassword.min'=> 'La confirmacion debe tener al menos 8 caracteres',
            'cpassword.same'=> 'Las contraseñas no coinciden'
        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()):
            return back()->withErrors($validator)->with('message','Se ha producido un error: ')->with('typealert','danger');
        else:     
            $user = User::findOrFail(Auth::id());
            if(Hash::check($request->input('old_password'), $user->password)):
                $user->password = Hash::make($request->input('password'));
                if($user->save()):
                    return back()->with('message', 'Su contraseña fue cambiada con éxito.')->with('typealert', 'success');
                endif;
            else:
                return back()->with('message', 'Su contraseña actual es errónea.')->with('typealert', 'danger');
            endif;            
        endif;
    }

    public function postMiCuentaInfo(Request $request){
        $rules = [
            'name'=> 'required',
            'lastname' => 'required'
        ];

        $messages = [
            'name.required'=> 'Su nombre es requerido',
            'lastname.required'=> 'Su apellido es requerido'
        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()):
            return back()->withErrors($validator)->with('message','Se ha producido un error: ')->with('typealert','danger');
        else:
            $user = User::findOrFail(Auth::id());
            $user->name = e($request->input('name'));
            $user->lastname = e($request->input('lastname'));

            if($user->save()):
                return back()->with('message', 'Sus datos fueron actualizados con éxito.')->with('typealert', 'success');
            endif;
        endif;
    }

    public function getRegister(){
        return view('admin.usuarios.register');
    }

    public function postRegister(Request $request){
        $rules = [
            'name'=> 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8'
        ];

        $messages = [
            'name.required'=> 'Su nombre es requerido',
            'lastname.required'=> 'Su apellido es requerido',
            'email.required'=> 'Su correo es requerido',
            'email.email'=> 'Su correo es invalido',
            'email.unique'=> 'Este correo ya existe',
            'password.required'=> 'Por favor escriba una contraseña',
            'password.min'=> 'Debe tener al menos 8 caracteres'
        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()):
            return back()->withErrors($validator)->with('message','Se ha producido un error: ')->with('typealert','danger');
        else:
            $user = new user;
            $user->name = e($request->input('name'));
            $user->lastname = e($request->input('lastname'));
            $user->email = e($request->input('email'));
            $user->password = Hash::make($request->input('password'));

            $data = ['name'=>$user->name, 'email'=>$user->email, 'password'=>$request->input('password') ];

            if($user->save()):
                Mail::to($user->email)->send(new EnvioNuevoUsuarioyContraseña($data));
                return redirect('/admin/usuarios/'.$user->id.'/edit')->with('message', 'El usuario registrado con éxito. Seleccione el rol que tendrá.')->with('typealert', 'success');
            endif;
        endif;

    }
}