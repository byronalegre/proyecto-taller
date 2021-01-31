<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTable;
use App\Http\Models\Pieza;

class DatatableController extends Controller
{
    // public function piezas($status){
    // 	switch ($status) {
    //         case '0':
    //             $piezas = Pieza::with(['cat','mark'])->where('status','0')->get();
    //             break;
    //          case '1':
    //             $piezas = Pieza::with(['cat','mark'])->where('status','1')->get();
    //         case 'all':
    //             $piezas = Pieza::with(['cat','mark'])->get();
    //             break;
    //         case 'trash':
    //             $piezas = Pieza::with(['cat','mark'])->onlyTrashed()->get();
    //             break;
            
    //     }
    //     return datatables()->of($piezas)->toJson();
    // }
}
