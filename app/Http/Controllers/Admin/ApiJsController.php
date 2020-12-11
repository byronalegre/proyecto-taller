<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\Pieza;
use App\Http\Models\Compra;

class ApiJsController extends Controller
{
    function getPiezas($seccion, Request $request){
    	switch ($seccion) {
    		case 'tareas':
    			$data = Pieza::where('status', 1)->get();
    			break;
    		case 'inicio':
    			$data = Compra::all();
    			break;
    		default:
    			$data = 0;
    			break;
    	}
    	return $data;
    }
}
