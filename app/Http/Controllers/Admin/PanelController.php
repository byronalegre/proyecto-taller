<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\Categoria, App\Http\Models\Pieza, App\Http\Models\Compra, App\Http\Models\Tarea;
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
    	$cats = Categoria::where('seccion','0')->pluck('name','id');;

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

        $compras_mes = 0;
        foreach($compras as $c){
           $fecha = date_parse($c->created_at);
           if($fecha['year'] == (Carbon::now()->format('Y'))){
               if($fecha['month'] == (Carbon::now()->format('m'))){
                  $compras_mes++;
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

        $tareas = Tarea::all();
        $pendiente = 0;
        $completada = 0;

        foreach ($tareas as $t) {
            if($t->status == 0){
                $pendiente++;
            }
            if($t->status == 1){
                $completada++;
            }
        }

    	$data = ['cats'=>$cats,
                 'piezas'=>$piezas,'piezas_act'=> $piezas_act,'piezas_inact'=> $piezas_inact,
                 'compras'=>$compras, 'compra_1'=>$compra_1, 'compra_2'=>$compra_2, 'compra_3'=>$compra_3, 'compra_4'=>$compra_4, 'compra_5'=>$compra_5, 'compra_6'=>$compra_6, 'compra_7'=>$compra_7, 'compra_8'=>$compra_8, 'compra_9'=>$compra_9, 'compra_10'=>$compra_10, 'compra_11'=>$compra_11, 'compra_12'=>$compra_12, 'compras_mes'=>$compras_mes,
                 'tareas'=>$tareas, 'pendiente'=>$pendiente, 'completada'=>$completada
                ];

    	return view('admin.panel', $data);
    }
}
