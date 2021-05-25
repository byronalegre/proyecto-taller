<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\Categoria, App\Http\Models\Pieza, App\Http\Models\Remito, App\Http\Models\OrdenPedido, App\Http\Models\OrdenCompra, App\Http\Models\OrdenTrabajo;
use Carbon\Carbon, Auth;

class PanelController extends Controller
{
    public function __construct(){
    	$this->middleware('auth');
    	$this->middleware('estadoUsuario');
    	$this->middleware('permisosUsuario');
    	$this->middleware('isadmin');

    }

    public function getPanel(){   
        $piezas_stock_min=0;
        $piezas_stock_normal=0;
        $piezas_sin_stock=0;
        //
        $pendiente=0;
        $completada=0;
        //----------------- 
        $c_pend=0;
        // $c_ap=0;
        $c_comp=0;
        $c_rec=0;
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
        $compras_mes=0;
        //-----------------        
        $total = 0;
        //-----------------    	    
        
        $compras = Remito::all();
        
        //-----------------

        $piezas = Pieza::where('status', 1)->orderBy('name','asc')->get();    

        //-----------------

        $op_nuevas = OrdenPedido::where('status', 0)->whereYear('created_at','=', Carbon::now()->format('Y'))->whereMonth('created_at','=', Carbon::now()->format('m'))->whereDay('created_at','<=', Carbon::now()->format('d'))->count();

         //-----------------

        $oc = OrdenCompra::all();
        $oc_nuevas = OrdenCompra::where('status', 0)->whereYear('created_at','=', Carbon::now()->format('Y'))->whereMonth('created_at','=', Carbon::now()->format('m'))->whereDay('created_at','<=', Carbon::now()->format('d'))->count();

         //-----------------
        
        $tareas = OrdenTrabajo::all();
        $t_nuevas = OrdenTrabajo::where('status', 0)->whereYear('created_at','=', Carbon::now()->format('Y'))->whereMonth('created_at','=', Carbon::now()->format('m'))->whereDay('created_at','<=', Carbon::now()->format('d'))->count();    

        //-----------------

        //OBTIENE PIEZAS POR STOCK

        foreach($piezas as $p){
            if(($p->cantidad_min > $p->cantidad)&&($p->cantidad != 0)){
                $piezas_stock_min ++;
            }
            if($p->cantidad >= $p->cantidad_min){
                $piezas_stock_normal ++;
            }
            if($p->cantidad == 0){
                $piezas_sin_stock ++;
            }
        }

        //OBTIENE TAREAS POR STATUS

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

        //OBTIENE REMITOS POR FECHA

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

        //OBTIENE OC POR STATUS

        foreach($oc as $value){
          $fecha_oc = date_parse($value->created_at);

           if(($fecha_oc['year'] == (Carbon::now()->format('Y'))) && ($fecha_oc['month'] == (Carbon::now()->format('m')))){
              switch ($value->status) {
                 case '0':
                   $c_pend++;
                   break;
                 // case '1':
                 //   $c_ap++;
                 //   break;
                 case '1':
                   $c_comp++;
                   break;
                 case '2':
                   $c_rec++;
                   break;
               }
            }
         }

        //--------------
    	
        $data = [  'oc'=>$oc,
                 'piezas'=>$piezas,'piezas_stock_min'=> $piezas_stock_min,'piezas_stock_normal'=> $piezas_stock_normal, 'piezas_sin_stock'=> $piezas_sin_stock,
                 'compras'=>$compras, 'compra_1'=>$compra_1, 'compra_2'=>$compra_2, 'compra_3'=>$compra_3, 'compra_4'=>$compra_4, 'compra_5'=>$compra_5, 'compra_6'=>$compra_6, 'compra_7'=>$compra_7, 'compra_8'=>$compra_8, 'compra_9'=>$compra_9, 'compra_10'=>$compra_10, 'compra_11'=>$compra_11, 'compra_12'=>$compra_12, 'compras_mes'=>$compras_mes, 'c_pend'=>$c_pend, /*'c_ap'=>$c_ap,*/ 'c_comp'=>$c_comp, 'c_rec'=>$c_rec, 'total'=>$total,
                 'tareas'=>$tareas, 'pendiente'=>$pendiente, 'completada'=>$completada, 't_nuevas'=>$t_nuevas, 'oc_nuevas'=>$oc_nuevas, 'op_nuevas'=>$op_nuevas
                ];

    	return view('admin.panel', $data);
    }
}
        //--------------------------------------CONSULTAS ANTERIORES----------------------------------------

        //--------------------------------------------------------------------------------------------------
        // foreach($piezas as $p){
        //     if($p->status == 1){
        //         $piezas_act ++;
        //     }
        //     if($p->status == 0){
        //         $piezas_inact ++;
        //     }
        // }
        //--------------------------------------------------------------------------------------------------
       //--------------------------------------------------------------------------------------------------
        // foreach ($tareas as $t) {
        //   $fecha_t = date_parse($t->created_at);

        //      if($fecha_t['year'] == (Carbon::now()->format('Y'))){
        //       if($t->status == 0){
        //           $pendiente++;
        //       }
        //       if($t->status == 1){
        //           $completada++;
        //       }
        //   }
        // }
        //--------------------------------------------------------------------------------------------------
        // foreach($oc as $value){
        //   $fecha_oc = date_parse($value->created_at);

        //    if(($fecha_oc['year'] == (Carbon::now()->format('Y'))) && ($fecha_oc['month'] == (Carbon::now()->format('m')))){
        //       switch ($value->status) {
        //          case '0':
        //            $c_pend++;
        //            break;
        //          case '1':
        //            $c_ap++;
        //            break;
        //          case '2':
        //            $c_comp++;
        //            break;
        //          case '3':
        //            $c_rec++;
        //            break;
        //        }
        //     }
        //  }
        //---------------------------------------------------------------------------------------------------
        // $compras_mes = $compras->count();
        //---------------------------------------------------------------------------------------------------
        // $compra_1= Remito::whereYear('created_at', Carbon::now()->format('Y'))->whereMonth('created_at', 1)->count();
        // $compra_2= Remito::whereYear('created_at', Carbon::now()->format('Y'))->whereMonth('created_at', 2)->count();
        // $compra_3= Remito::whereYear('created_at', Carbon::now()->format('Y'))->whereMonth('created_at', 3)->count();
        // $compra_4= Remito::whereYear('created_at', Carbon::now()->format('Y'))->whereMonth('created_at', 4)->count();
        // $compra_5= Remito::whereYear('created_at', Carbon::now()->format('Y'))->whereMonth('created_at', 5)->count();
        // $compra_6= Remito::whereYear('created_at', Carbon::now()->format('Y'))->whereMonth('created_at', 6)->count();
        // $compra_7= Remito::whereYear('created_at', Carbon::now()->format('Y'))->whereMonth('created_at', 7)->count();
        // $compra_8= Remito::whereYear('created_at', Carbon::now()->format('Y'))->whereMonth('created_at', 8)->count();
        // $compra_9= Remito::whereYear('created_at', Carbon::now()->format('Y'))->whereMonth('created_at', 9)->count();
        // $compra_10= Remito::whereYear('created_at', Carbon::now()->format('Y'))->whereMonth('created_at', 10)->count();
        // $compra_11= Remito::whereYear('created_at', Carbon::now()->format('Y'))->whereMonth('created_at', 11)->count();
        // $compra_12= Remito::whereYear('created_at', Carbon::now()->format('Y'))->whereMonth('created_at', 12)->count();
        //---------------------------------------------------------------------------------------------------
        // foreach($compras as $c){
        //    // $fecha = date_parse($c->created_at);

        //    // if($fecha['year'] == (Carbon::now()->format('Y'))){
        //        // if($fecha['month'] == (Carbon::now()->format('m'))){
        //           // $compras_mes++;
        //           $total += $c->importe_total;
        //        // }
        //   // }
        // }
        //---------------------------------------------------------------------------------------------------

        // $c_pend = OrdenCompra::where('status', 0)->whereYear('created_at', Carbon::now()->format('Y'))->whereMonth('created_at', Carbon::now()->format('m'))->count();
        // $c_ap = OrdenCompra::where('status', 1)->whereYear('created_at', Carbon::now()->format('Y'))->whereMonth('created_at', Carbon::now()->format('m'))->count();
        // $c_comp = OrdenCompra::where('status', 2)->whereYear('created_at', Carbon::now()->format('Y'))->whereMonth('created_at', Carbon::now()->format('m'))->count();
        // $c_rec = OrdenCompra::where('status', 3)->whereYear('created_at', Carbon::now()->format('Y'))->whereMonth('created_at', Carbon::now()->format('m'))->count();

        //---------------------------------------------------------------------------------------------------

        // $piezas_act = Pieza::where('status',1)->count();
        // $piezas_inact = Pieza::where('status',0)->count();
        // $pendiente = OrdenTrabajo::where('status', 0)->count();
        // $completada = OrdenTrabajo::where('status', 1)->count();