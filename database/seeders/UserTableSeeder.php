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
        $this->developerAccounts();
    }

    public static function getEmailFromName($name)
    {
        return strtolower(str_replace(' ', '_', iconv('UTF-8', 'ASCII//TRANSLIT', $name))) .
            fake()->randomNumber(5, false) .
            '@estga.pt';
    }

    public static function developerAccounts()
    {
        Docente::create([
            'numero_funcionario' => "85095",
            'acn_id' => 1,
            'numero_telefone' => '960444644',
        ]);
        User::create([
            'nome' => 'Miguel Marques Vieira',
            'email' => 'miguelnamarinha@gmail.com',
            'password' => bcrypt('password'),
            'admin' => true,
            'docente_id' => 12
        ]);

        Docente::create([
            'numero_funcionario' => "85096",
            'acn_id' => 1,
            'numero_telefone' => '',
        ]);
        User::create([
            'nome' => 'Miguel Marques Vieira Docente',
            'email' => 'miguelmvieira@ua.pt',
            'password' => bcrypt('password'),
            'admin' => false,
            'docente_id' => 13
        ]);

        User::create([
            'nome' => 'Miguel Marques Vieira Admin',
            'email' => 'miguelnamarinha@sapo.pt',
            'password' => bcrypt('password'),
            'admin' => true
        ]);
    }
}
