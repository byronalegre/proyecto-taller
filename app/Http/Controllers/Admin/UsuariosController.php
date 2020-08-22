<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Validator,Auth,Hash;
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
    		$users= User::orderBy('id','Desc')->paginate(5);
    	else:
    		$users= User::where('status', $status)->orderBy('id','Desc')->paginate(5);
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

        if($request->input('rol_user') == "1"):
            if(is_null($u->permisos)):
                $permisos = [
                    'Panel_controller' => true
                ];

                $permisos = json_encode($permisos);
                $u->permisos = $permisos;
            endif;
        else:
            $u->permisos = null;
        endif;
        if($u->save()):
            if(($request->input('rol_user') == "1") || ($request->input('rol_user') == "2") || ($request->input('rol_user') =="3")):  //luego de cambiar el rol te dirige a los permisos. se agrego desde || ($request->input('rol_user') == "2") || ($request->input('rol_user') =="3")
                return redirect('admin/usuarios/'.$u->id.'/permisos')->with('message', 'El rol del usuario se actualizo con éxito.')->with('typealert', 'success');
            else:
                return back()->with('message', 'El rol del usuario se actualizo con éxito.')->with('typealert', 'success');
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
    		return back()->with('message', 'Los permisos del usuario fueron actualizados.')->with('typealert', 'success');
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
}