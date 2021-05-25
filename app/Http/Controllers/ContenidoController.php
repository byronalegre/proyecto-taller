<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContenidoController extends Controller
{
   	public function getHome(){
   		return view('home');
   	}
}
