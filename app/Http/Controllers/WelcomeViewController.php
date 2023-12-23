<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeViewController extends Controller
{
    public function welcome() {

        return view('entrada', ['page_title' => 'Bem-vindo!']);
    }

    public function inicio() {
        
        return view('inicio', ['page_title' => 'Página Inicial']);
    }
}
