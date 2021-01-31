<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\Categoria, App\Http\Models\Pieza, App\Http\Models\Remito, App\Http\Models\OrdenPedido, App\Http\Models\OrdenCompra, App\Http\Models\OrdenTrabajo;
use Carbon\Carbon;

class PanelController extends Controller
{
    public function __construct(){
    	$this->middleware('auth');
    	$this->middleware('estadoUsuario');
    	$this->middleware('permisosUsuario');
    	$this->middleware('isadmin');

    }

    public function getPanel(){
        //Consultas bdd
    	  $piezas = Pieza::all();
        $compras = Remito::all();
        $tareas = OrdenTrabajo::all();
        $oc = OrdenCompra::all();

        //-----------------
        $piezas_act = 0;
        $piezas_inact = 0;
        //-----------------
        $compra_1=0;
        $compra_2=0;
        $compra_3=0;
        $compra_4=0;
        $compra_5=0;
        $compra_6=0;
        $compra_7=0;
        $compra_8=0;
        $compra_9=0;
        $compra_10=0;
        $compra_11=0;
        $compra_12=0;
        //-----------------
        $compras_mes = 0;
        //-----------------
        $c_pend = 0;
        $c_ap = 0;
        $c_comp = 0;
        $c_rec = 0;
        //-----------------
        $total = 0;
        //-----------------
        $pendiente = 0;
        $completada = 0;
        
        //--------------------------------------------------------------------------------------------------
        foreach($piezas as $p){
            if($p->status == 1){
                $piezas_act ++;
            }
            if($p->status == 0){
                $piezas_inact ++;
            }
        }
        //--------------------------------------------------------------------------------------------------
        foreach($compras as $c){

           $fecha = date_parse($c->created_at);

           if($fecha['year'] == (Carbon::now()->format('Y'))){
               if($fecha['month'] == (Carbon::now()->format('m'))){
                  $compras_mes++;
                  $total += $c->importe_total;
               }
               
               switch ($fecha['month']) {
                    case '1':
                       $compra_1++;
                       break;
                    case '2':
                       $compra_2++;
                       break;
                    case '3':
                       $compra_3++;
                       break;
                    case '4':
                       $compra_4++;
                       break;
                    case '5':
                       $compra_5++;
                       break;
                    case '6':
                       $compra_6++;
                       break;
                    case '7':
                       $compra_7++;
                       break;
                    case '8':
                       $compra_8++;
                       break;
                    case '9':
                       $compra_9++;
                       break;
                    case '10':
                       $compra_10++;
                       break;
                    case '11':
                       $compra_11++;
                       break;
                    case '12':
                       $compra_12++;
                       break;
               }        
           }
        }
        //--------------------------------------------------------------------------------------------------
        foreach ($tareas as $t) {
          $fecha_t = date_parse($t->created_at);

             if($fecha_t['year'] == (Carbon::now()->format('Y'))){
              if($t->status == 0){
                  $pendiente++;
              }
              if($t->status == 1){
                  $completada++;
              }
          }
        }
        //--------------------------------------------------------------------------------------------------
        foreach($oc as $value){
          $fecha_oc = date_parse($value->created_at);

           if(($fecha_oc['year'] == (Carbon::now()->format('Y'))) && ($fecha_oc['month'] == (Carbon::now()->format('m')))){
              switch ($value->status) {
                 case '0':
                   $c_pend++;
                   break;
                 case '1':
                   $c_ap++;
                   break;
                 case '2':
                   $c_comp++;
                   break;
                 case '3':
                   $c_rec++;
                   break;
               }
            }
         }

    	$data = [  'oc'=>$oc,
                 'piezas'=>$piezas,'piezas_act'=> $piezas_act,'piezas_inact'=> $piezas_inact,
                 'compras'=>$compras, 'compra_1'=>$compra_1, 'compra_2'=>$compra_2, 'compra_3'=>$compra_3, 'compra_4'=>$compra_4, 'compra_5'=>$compra_5, 'compra_6'=>$compra_6, 'compra_7'=>$compra_7, 'compra_8'=>$compra_8, 'compra_9'=>$compra_9, 'compra_10'=>$compra_10, 'compra_11'=>$compra_11, 'compra_12'=>$compra_12, 'compras_mes'=>$compras_mes, 'c_pend'=>$c_pend, 'c_ap'=>$c_ap, 'c_comp'=>$c_comp, 'c_rec'=>$c_rec, 'total'=>$total,
                 'tareas'=>$tareas, 'pendiente'=>$pendiente, 'completada'=>$completada
                ];

    	return view('admin.panel', $data);
    }
}
