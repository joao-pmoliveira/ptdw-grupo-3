<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WelcomeViewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('inicio');
    }

    public function welcome()
    {

        return view('entrada', ['page_title' => 'Bem-vindo!']);
    }

    public function inicio()
    {
        $user = Auth::check() ? Auth::user() : NULL;

        return view('inicio', [
            'page_title' => 'Página Inicial',
            'user' => $user,
        ]);
    }
}
