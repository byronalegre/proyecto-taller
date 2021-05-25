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

    public function getUsuarios($status, Request $request){
        $search = $request->input('search');
        $pag = $request->input('paginate');

        if($pag):
            session(['paginate'=> $pag]);
        else:
            $pag = session('paginate');
        endif;

        if($search){
            $users = User::where('id', $search)
                        ->orWhere('name', 'LIKE', '%'. $search. '%' )
                        ->orWhere('lastname', 'LIKE', '%'. $search. '%' )
                        ->orWhere('email', 'LIKE', '%'. $search. '%' )
                        ->orWhere('role', getIdRoleUsuarioArray(null, $search) )
                        ->orWhere('status', 'LIKE', '%'. $search. '%' )
                        ->orderBy('id', 'desc')
                        ->paginate($pag);
        }
        else{
            if($status == 'all'):
                $users= User::orderBy('id','desc')->paginate($pag);
            else:
                $users= User::where('status', $status)->orderBy('id','desc')->paginate($pag);
            endif;
        }    	

    	$data = ['users'=> $users, 'status'=>$status, 'search'=>$search];
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
        //Si es 4 (E. TAREAS)- solor realiza tareas
        
            if($request->input('rol_user') == "1"):  
                $u->permisos = null;         
                if(is_null($u->permisos)):
                    $permisos = [
                        "inicio"=>true,
                        "estadisticas_rapidas"=>true,
                        "e_tareas"=>true, "e_compras"=>true,                    
                        "graficos"=>true,
                        "piezas"=>true, "piezas_agregar"=>true, "piezas_editar"=>true, "piezas_eliminar"=>true, "piezas_buscar"=>true, "piezas_pdf"=>true, "piezas_pdf_stock"=>true , "pieza_detalle"=>true, "historia_precio"=>true, "historia"=>true, "historia_detalle"=>true,
                        "categorias"=>true, "categorias_agregar"=>true,"categorias_editar"=>true,"categorias_eliminar"=>true, 
                        "usuarios_list"=>true, "usuarios_editar"=>true, "usuarios_suspend"=>true, "usuarios_permisos"=>true, "usuarios_buscar"=>true, "usuarios_register"=>true,
                        "micuenta_editar"=>true, "micuenta_password"=>true, "micuenta_info"=>true,
                        "proveedores"=>true, "proveedores_agregar"=>true, "proveedores_editar"=>true, "proveedores_eliminar"=>true, "proveedores_buscar"=>true, "proveedores_pdf"=>true,
                        "compras"=>true, "compras_agregar"=>true, "remitos_agregar_directo"=>true, "compras_editar"=>true, "compras_eliminar"=>true, "compra_detalle"=>true, "detalle_compra_pdf"=>true, "reporte_compras_pdf"=>true, "reporte_compras_mes_pdf"=>true, "reporte_compras_ano_pdf"=>true,
                        "pedidos"=>true, "pedidos_agregar"=>true, "compras_agregar_directo"=>true, "pedidos_editar"=>true, "pedidos_eliminar"=>true, "pedido_detalle"=>true, "detalle_pedido_pdf"=>true, "reporte_pedidos_pdf"=>true, "reporte_pedidos_mes_pdf"=>true, "reporte_pedidos_ano_pdf"=>true,
                        "remitos"=>true, "remitos_agregar"=>true, "remitos_eliminar"=>true, "remito_detalle"=>true, "detalle_remito_pdf"=>true, "reporte_remitos_pdf"=>true, "reporte_remitos_mes_pdf"=>true, "reporte_remitos_ano_pdf"=>true,
                         "tareas"=>true, "tareas_agregar"=>true, "tareas_editar"=>true, "tareas_completar"=>true, "tareas_eliminar"=>true, "tarea_detalle"=>true, "detalle_tarea_pdf"=>true, "reporte_tareas_pdf"=>true, "reporte_tareas_mes_pdf"=>true, "reporte_tareas_ano_pdf"=>true,
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
                        "piezas"=>true, "piezas_agregar"=>true, "piezas_editar"=>true, "piezas_eliminar"=>true, "piezas_buscar"=>true, "piezas_pdf"=>true, "piezas_pdf_stock"=>true, "pieza_detalle"=>true,  
                        "categorias"=>true, "categorias_agregar"=>true,"categorias_editar"=>true,                         
                        "micuenta_editar"=>true, "micuenta_password"=>true, "micuenta_info"=>true,
                        "tareas"=>true, "tarea_detalle"=>true, 
                        "pedidos"=>true, "pedidos_agregar"=>true, "pedidos_editar"=>true, "pedidos_eliminar"=>true, "pedido_detalle"=>true, "detalle_pedido_pdf"=>true, "reporte_pedidos_pdf"=>true, "reporte_pedidos_mes_pdf"=>true, "reporte_pedidos_ano_pdf"=>true,
                        "compras"=>true, "remitos_agregar_directo"=>true, "compra_detalle"=>true, "detalle_compra_pdf"=>true,
                        "remitos"=>true, "remitos_agregar"=>true, "remitos_eliminar"=>true, "remito_detalle"=>true, "detalle_remito_pdf"=>true, "reporte_remitos_pdf"=>true, "reporte_remitos_mes_pdf"=>true, "reporte_remitos_ano_pdf"=>true
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
                        "piezas"=>true, "piezas_agregar"=>true, "piezas_buscar"=>true, "piezas_pdf"=>true, "pieza_detalle"=>true, "historia_precio"=>true, 
                        "micuenta_editar"=>true, "micuenta_password"=>true, "micuenta_info"=>true,
                         "categorias"=>true, "categorias_agregar"=>true,"categorias_editar"=>true, 
                        "proveedores"=>true, "proveedores_agregar"=>true, "proveedores_editar"=>true, "proveedores_eliminar"=>true, "proveedores_buscar"=>true, "proveedores_pdf"=>true,
                        "compras"=>true, "compras_agregar"=>true, "compras_agregar_directo"=>true, "compras_editar"=>true, "compras_eliminar"=>true, "compra_detalle"=>true, "detalle_compra_pdf"=>true, "reporte_compras_pdf"=>true, "reporte_compras_mes_pdf"=>true, "reporte_compras_ano_pdf"=>true,
                        "pedidos"=>true, "pedido_detalle"=>true,
                        "remitos"=>true, "remito_detalle"=>true, "detalle_remito_pdf"=>true, "reporte_remitos_pdf"=>true, "reporte_remitos_mes_pdf"=>true, "reporte_remitos_ano_pdf"=>true
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
                        "piezas"=>true, "piezas_buscar"=>true, "pieza_detalle"=>true, "piezas_pdf"=>true, "piezas_pdf_stock"=>true, 
                        "e_tareas"=>true,                    
                        "graficos"=>true,                         
                        "categorias"=>true, "categorias_agregar"=>true,"categorias_editar"=>true,
                        "pedidos"=>true, "pedidos_agregar"=>true, "pedidos_editar"=>true, "pedidos_eliminar"=>true, "pedido_detalle"=>true, "detalle_pedido_pdf"=>true,
                        "micuenta_editar"=>true, "micuenta_password"=>true, "micuenta_info"=>true,
                        "tareas"=>true, "tareas_agregar"=>true, "tareas_editar"=>true, "tareas_completar"=>true, "tareas_eliminar"=>true, "tarea_detalle"=>true, "detalle_tarea_pdf"=>true,      
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
            'old_password.required'=> 'Por favor escriba su contraseña actual',
            'old_password.min'=> 'Debe tener al menos 8 caracteres',
            'password.required'=> 'Por favor escriba su nueva contraseña',
            'password.min'=> 'Debe tener al menos 8 caracteres',
            'cpassword.required'=> 'Confirme su nueva contraseña',
            'cpassword.min'=> 'La confirmación debe tener al menos 8 caracteres',
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
            'name'=> 'required|max:15',
            'lastname' => 'required|max:15'
        ];

        $messages = [
            'name.required'=> 'Su nombre es requerido',
            'name.max'=> 'El nombre debe tener menos de 15 caracteres',
            'lastname.required'=> 'Su apellido es requerido',
            'lastname.max'=> 'El apellido debe tener menos de 15 caracteres',
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
            'name'=> 'required|max:20',
            'lastname' => 'required|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8'
        ];

        $messages = [
            'name.required'=> 'El nombre es requerido',
            'lastname.required'=> 'El apellido es requerido',
            'name.max'=> 'El nombre debe tener menos de 20 caracteres',
            'lastname.max'=> 'El apellido debe tener menos de 20 caracteres',
            'email.required'=> 'El correo es requerido',
            'email.email'=> 'El correo es invalido',
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

    public function order($status, $campo, $direc, Request $request){
        $search = $request->input('search');
        $pag = $request->input('paginate');

        if($pag):
            session(['paginate'=> $pag]);
        else:
            $pag = session('paginate');
        endif;

        if($search){
            $users = User::where('id', $search)
                        ->orWhere('name', 'LIKE', '%'. $search. '%' )
                        ->orWhere('lastname', 'LIKE', '%'. $search. '%' )
                        ->orWhere('email', 'LIKE', '%'. $search. '%' )
                        ->orWhere('role', getIdRoleUsuarioArray(null, $search) )
                        ->orWhere('status', 'LIKE', '%'. $search. '%' )
                        ->orderBy('id', 'desc')
                        ->paginate($pag);
        }
        else{
            if($campo == 'status'):
                if($direc == 'asc'):
                    if($status == 'all'):
                        $users= User::orderBy($campo, 'desc')->paginate($pag);
                    else:
                        $users= User::where('status', $status)->orderBy($campo, 'desc')->paginate($pag);
                    endif;
                else:
                    if($status == 'all'):
                        $users= User::orderBy($campo, 'asc')->paginate($pag);
                    else:
                        $users= User::where('status', $status)->orderBy($campo, 'asc')->paginate($pag);
                    endif;
                endif;
            else:
                if($status == 'all'):
                    $users= User::orderBy($campo, $direc)->paginate($pag);
                else:
                    $users= User::where('status', $status)->orderBy($campo, $direc)->paginate($pag);
                endif;
            endif;
        }    	

    	$data = ['users'=> $users, 'status'=>$status, 'search'=>$search];
    	return view('admin.usuarios.home', $data);
    }
}