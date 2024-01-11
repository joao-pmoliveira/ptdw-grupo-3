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
                'email' => $this->getEmailFromName($nome),
                'password' => bcrypt('password'),
                'admin' => rand(0, 9) < 3 ? true : false,
                'docente_id' => $docente->id
            ]);
        }

        $percentagem_admin = 0.10;
        for ($i = 0; $i < ceil(count($docentes) * $percentagem_admin); $i++) {
            $nome = $faker->unique()->name();
            User::create([
                'nome' => $nome,
                'email' => $this->getEmailFromName($nome),
                'password' => bcrypt('password'),
                'admin' => true,
            ]);
        }
    }

    public static function getEmailFromName($name)
    {
        return strtolower(str_replace(' ', '_', iconv('UTF-8', 'ASCII//TRANSLIT', $name))) .
            fake()->randomNumber(5, false) .
            '@estga.pt';
    }
}
