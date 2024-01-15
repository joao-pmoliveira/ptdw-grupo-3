<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegistoController extends Controller
{
    public function show()
    {
        return view('registo', ['page_title' => 'Registar Conta']);
    }

    public function register()
    {
    }
}
