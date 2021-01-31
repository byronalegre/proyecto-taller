<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\Pieza;
use App\Http\Models\Remito;

class ApiJsController extends Controller
{   
     function getItems(Request $request){
        $data = Pieza::all()->pluck('name','id');
        return $data;
    }

    function getAll(Request $request){
        $data = Pieza::all()->pluck('name','id');
        return $data;
    }

    // function getItems($seccion, Request $request){
    // 	switch ($seccion) {
    // 		case 'tareas_agregar':
    // 			$data = Pieza::all()->pluck('name','id');
    // 			break;
    // 		default:
    // 			$data = 0;
    // 			break;
    // 	}
    // 	return $data;
    // }

    // function getAll($seccion, Request $request){
    //     switch ($seccion) {            
    //         case 'remitos_agregar':
    //             $data = Pieza::all()->pluck('name','id');
    //             break;            
    //         default:
    //             $data = 0;
    //             break;
    //     }
    //     return $data;
    // }
}
