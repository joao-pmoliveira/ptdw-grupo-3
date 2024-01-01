<?php

namespace Database\Seeders;

use App\Models\Docente;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;

class UserTableSeeder extends Seeder
{
    public function run(): void
    {
        $faker = FakerFactory::create('pt_PT');

        $docentes = Docente::all();

        foreach ($docentes as $docente) {
            $nome = $faker->unique()->name();

            User::create([
                'nome' => $nome,
                'email' => strtolower(str_replace(' ', '_', $nome)) . $faker->unique()->randomNumber(5, false) . '@estga.pt',
                'password' => bcrypt('password'),
                'admin' => rand(0, 1),
                'docente_id' => $docente->id
            ]);
        }
    }
}
