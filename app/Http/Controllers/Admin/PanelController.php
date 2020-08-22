<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User, App\Http\Models\Pieza, App\Http\Models\Compra;
class PanelController extends Controller
{
    public function __construct(){
    	$this->middleware('auth');
    	$this->middleware('estadoUsuario');
    	$this->middleware('permisosUsuario');
    	$this->middleware('isadmin');

    }

    public function getPanel(){
    	$users = User::count();
        $u_reg = User::where('status','0')->count();
        $u_susp = User::where('status','100')->count();        
        $piezas = Pieza::count();
    	$piezas_act = Pieza::where('status','1')->count();
        $piezas_inact = Pieza::where('status','0')->count();
        $compras = Compra::all();
    	$data = ['users'=>$users, 'u_reg'=>$u_reg, 'u_susp'=>$u_susp,'piezas'=>$piezas,'piezas_act'=> $piezas_act,'piezas_inact'=> $piezas_inact,'compras'=>$compras];

    	return view('admin.panel', $data);
    }
}
