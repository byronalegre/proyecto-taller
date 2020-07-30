<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User, App\Http\Models\Pieza;
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
    	$products = Pieza::where('status','1')->count();

    	$data = ['users'=>$users, 'products'=> $products];

    	return view('admin.Panel', $data);
    }
}
