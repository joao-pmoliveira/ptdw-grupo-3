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
                // todo @joao: remover geração do automatica do email
                'email' => $this->getEmailFromName($nome),
                'password' => bcrypt('password'),
                'admin' => rand(0, 9) < 3 ? true : false,
                'numero_funcionario' => $faker->unique()->randomNumber(4, true),
                'numero_telefone' => $faker->phoneNumber(),
                'docente_id' => $docente->id
            ]);
        }

        $percentagem_admin = 0.10;
        for ($i = 0; $i < ceil(count($docentes) * $percentagem_admin); $i++) {
            $nome = $faker->unique()->name();
            User::create([
                'nome' => $nome,
                // todo @joao: remover geração do automatica do email
                'email' => $this->getEmailFromName($nome),
                'password' => bcrypt('password'),
                'admin' => true,
                'numero_funcionario' => $faker->unique()->randomNumber(4, true),
                'numero_telefone' => $faker->phoneNumber(),
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
            'acn_id' => 1,
        ]);
        User::create([
            'nome' => 'Miguel Marques Vieira',
            'email' => 'miguelnamarinha@gmail.com',
            'password' => bcrypt('password'),
            'admin' => true,
            'docente_id' => 12,
            'numero_telefone' => '960444644',
            'numero_funcionario' => 85095,
        ]);

        Docente::create([
            'acn_id' => 1,
        ]);
        User::create([
            'nome' => 'Miguel Marques Vieira Docente',
            'email' => 'miguelmvieira@ua.pt',
            'password' => bcrypt('password'),
            'admin' => false,
            'docente_id' => 13,
            'numero_funcionario' => 85096,
            'numero_telefone' => '',
        ]);

        User::create([
            'nome' => 'Miguel Marques Vieira Admin',
            'email' => 'miguelnamarinha@sapo.pt',
            'password' => bcrypt('password'),
            'admin' => true,
            'numero_funcionario' => 85097,
            'numero_telefone' => '',
        ]);

        Docente::create([
            'acn_id' => 1,
        ]);
        User::create([
            'nome' => 'Docente Exemplo',
            'email' => 'docente.exemplo@ua.pt',
            'password' => bcrypt('password'),
            'admin' => false,
            'docente_id' => 14,
            'numero_funcionario' => 85195,
            'numero_telefone' => '',
        ]);

        User::create([
            'nome' => 'Comissão de Horário Exemplo',
            'email' => 'admin.exemplo@ua.pt',
            'password' => bcrypt('password'),
            'admin' => true,
            'numero_funcionario' => 85196,
            'numero_telefone' => '',
        ]);
    }
}
