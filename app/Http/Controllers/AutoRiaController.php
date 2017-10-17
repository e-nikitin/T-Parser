<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libs\Autoria\AutoriaAPI as AutoriaAPI;

class AutoRiaController extends Controller
{

    public function index() {
      // dd('hello!');
        $AutoriaAPI = new AutoriaAPI();
        $AutoriaAPI->index();
    }
}
