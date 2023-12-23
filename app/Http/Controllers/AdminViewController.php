<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminViewController extends Controller
{
    public function gerirDados() {
        return view('gerirDados', ['page_title' => 'Gerir Dados']);
    }
}
