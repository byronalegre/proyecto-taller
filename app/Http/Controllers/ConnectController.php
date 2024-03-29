<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator,Hash,Auth, Mail, Str;
use App\Mail\EnvioRecuperarUsuario,App\Mail\EnvioNuevaContraseñaUsuario;
use App\User;

class ConnectController extends Controller
{
	public function __construct(){
		$this->middleware('guest')->except(['getLogout']);
	}
    public function getLogin(){
    	return view('connect.login');
    }
   /*  public function getRegister(){
    	return view('connect.register');
    }*/

    public function postLogin(Request $request){
    	$rules = [
    		'email' => 'required|email',
    		'password' => 'required|min:8'
    	];

    	$messages = [
    		'email.required'=> 'Su correo es requerido',
    		'email.email'=> 'Su correo es invalido',
    		'password.required'=> 'Por favor escriba una contraseña',
    		'password.min'=> 'Debe tener al menos 8 caracteres'
    	];

    	$validator = Validator::make($request->all(), $rules, $messages);
    	if($validator->fails()):
    		return back()->withErrors($validator)->with('message','Se ha producido un error: ')->with('typealert','danger');
    	else:

    		if (Auth::attempt(['email' => $request->input('email'),'password'=> $request->input('password')], true)):
                if(Auth::user()->status == "100"):
                    return redirect('/logout');
                else:
                    return redirect('/admin'); //ESTO RE DIRECCIONA A LA PAGINA ADMIN
                endif;
    		else:
    			return back()->with('message','Correo o contraseña incorrectos.')->with('typealert','danger');
    		endif;
    	
    	endif;
    }

 /*   public function postRegister(Request $request){
    	$rules = [
    		'name'=> 'required',
    		'lastname' => 'required',
    		'email' => 'required|email|unique:users,email',
    		'password' => 'required|min:8',
    		'cpassword' => 'required|min:8|same:password'
    	];

    	$messages = [
    		'name.required'=> 'Su nombre es requerido',
    		'lastname.required'=> 'Su apellido es requerido',
    		'email.required'=> 'Su correo es requerido',
    		'email.email'=> 'Su correo es invalido',
    		'email.unique'=> 'Este correo ya existe',
    		'password.required'=> 'Por favor escriba una contraseña',
    		'password.min'=> 'Debe tener al menos 8 caracteres',
    		'cpassword.required'=> 'Confirme su contraseña',
    		'cpassword.min'=> 'La confirmacion debe tener al menos 8 caracteres',
    		'cpassword.same'=> 'Las contraseñas no coinciden'
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

    		if($user->save()):
    			return redirect('/login')->with('message', 'Su usuario se creo correctamente. Ahora inicie sesión')->with('typealert', 'success');
    		endif;
    	endif;

    }*/

    public function getLogout(){
    $status = Auth::user()->status;
    Auth::logout();

    if($status == "100"):
        return redirect('/login')->with('message', 'Usuario deshabilitado.')->with('typealert', 'danger');
    else:
        return redirect('/');
    endif;
	
	}

    public function getRecover(){
        return view('connect.recover');
    }

    public function postRecover(Request $request){
        $rules = [           
            'email' => 'required|email'            
        ];

        $messages = [            
            'email.required'=> 'Su correo es requerido',
            'email.email'=> 'Su correo es inválido'           
        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()):
            return back()->withErrors($validator)->with('message','Se ha producido un error: ')->with('typealert','danger');
        else:
            $user = User::where('email',$request->input('email'))->count();
            if($user == "1"):
                $user = User::where('email',$request->input('email'))->first();
                $code = rand(100000,999999);
                $data = ['name'=>$user->name , 'email'=>$user->email, 'code'=>$code];
                $u = User::findOrFail($user->id);
                $u->password_code = $code;
                if($u->save()):
                Mail::to($user->email)->send(new EnvioRecuperarUsuario($data));
                return redirect('/reset?email='.$user->email)->with('message', 'Por favor, ingrese el código que se ha enviado a su correo.')->with('typealert', 'success');
                endif;
            else:       
                return back()->with('message', 'Este correo no existe.')->with('typealert', 'danger');
            endif;
        endif;

    }

    public function getReset(Request $request){
        $data=['email'=>$request->get('email')];

        return view('connect.reset', $data);
    }

    public function postReset(Request $request){
     $rules = [           
            'email' => 'required|email',
            'code' => 'required'            
        ];

        $messages = [            
            'email.required'=> 'Su correo es requerido',
            'email.email'=> 'Su correo es inválido',
            'code.required'=> 'El código de recuperación es requerido.'           
        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()):
            return back()->withErrors($validator)->with('message','Se ha producido un error: ')->with('typealert','danger');
        else:
            $user = User::where('email',$request->input('email'))->where('password_code', $request->input('code'))->count();
            if($user =="1"):
                $user = User::where('email',$request->input('email'))->where('password_code', $request->input('code'))->first();
                $nueva_password= Str::random(8);
                $user->password = Hash::make($nueva_password);
                $user->password_code=null;
                    if($user->save()):
                         $data = ['name'=>$user->name , 'password'=>$nueva_password];
                         Mail::to($user->email)->send(new EnvioNuevaContraseñaUsuario($data));
                         return redirect('/login')->with('message', 'La contraseña fue reestablecida con éxito. Por favor, inicie sesión con la contraseña que se le ha enviado al correo.')->with('typealert', 'success');
                    endif;
            else:
                return back()->with('message','El correo o código son incorrectos.')->with('typealert','danger');   
            endif;
        endif;
    }
}
