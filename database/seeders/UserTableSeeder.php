<?php

namespace Database\Seeders;

use App\Models\Docente;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    public function run(): void
    {
        $docentes = Docente::all();

        foreach ($docentes as $docente) {
            User::create([
                'nome' => $docente->nome,
                'email' => $docente->email,
                'password' => bcrypt('password'),
            ]);
        }
    }
}
