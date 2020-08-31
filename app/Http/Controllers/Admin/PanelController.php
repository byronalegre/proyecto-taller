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
    	$users = User::all();
        $u_reg = 0;
        $u_susp = 0;

        foreach($users as $u){
            if($u->status == 0){
                $u_reg ++;
            }
            if($u->status == 100){
                $u_susp ++;
            }
        }

        $piezas = Pieza::all();
        $piezas_act = 0;
        $piezas_inact = 0;

        foreach($piezas as $p){
            if($p->status == 1){
                $piezas_act ++;
            }
            if($p->status == 0){
                $piezas_inact ++;
            }
        }

        $compras = Compra::all();
        $compra_19=0;
        $compra_20=0;
        $compra_21=0;
        $compra_22=0;

        foreach($compras as $c){
           $fecha = date_parse($c->created_at);

            if( $fecha['year'] == 2019 ){
                $compra_19++;
            }
            if( $fecha['year'] == 2020 ){
                $compra_20++;
            }
            if( $fecha['year'] == 2021 ){
                $compra_21++;
            }
            if( $fecha['year'] == 2022 ){
                $compra_22++;
            }
        }
    	$data = ['users'=>$users, 'u_reg'=>$u_reg, 'u_susp'=>$u_susp,
                 'piezas'=>$piezas,'piezas_act'=> $piezas_act,'piezas_inact'=> $piezas_inact,
                 'compras'=>$compras, 'compra_19'=>$compra_19, 'compra_20'=>$compra_20, 'compra_21'=>$compra_21, 'compra_22'=>$compra_22
                ];

    	return view('admin.panel', $data);
    }
}
