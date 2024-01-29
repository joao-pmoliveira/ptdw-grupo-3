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

        $users = [
            # só admins - 3
            ["nome" => "Lara Sá", "admin" => true],
            ["nome" => "André Ferreira", "admin" => true],
            ["nome" => "Miguel Vieira", "admin" => true, "email" => "miguelnamarinha@sapo.pt"],
            ["nome" => "Admin Ex", "admin" => true, "email" => "adminexemplo@ua.pt"],
            # docentes_admins - 3
            ["nome" => "Filipe Loureiro", "admin" => true, "docente" => true],
            ["nome" => "Mauro Antunes", "admin" => true, "docente" => true],
            ["nome" => "Miguel Vieira", "admin" => true, "docente" => true, "email" => "miguelnamarinha@gmail.com"],
            # restantes docentes
            ["nome" => "Isaac Alves", "docente" => true],
            ["nome" => "Adriana Ribeiro", "docente" => true],
            ["nome" => "Álvaro Pinto", "docente" => true],
            ["nome" => "Mónica Matos", "docente" => true],
            ["nome" => "Gonçalo Coelho", "docente" => true],
            ["nome" => "Miguel Vieira", "docente" => true, "email" => "miguelmvieira@ua.pt"],
            ["nome" => "Docente Ex", "docente" => true, "email" => "docenteexemplo@ua.pt"],
        ];

        foreach ($users as $user) {
            $docenteId = null;
            if (isset($user["docente"])) {
                $docenteId = Docente::factory(1)->create()->first()->id;
            }

            User::create([
                "nome" => $user["nome"],
                "email" => $user["email"] ?? $this->getEmailFromName($user["nome"]),
                "password" => bcrypt("password"),
                "admin" => $user["admin"] ?? false,
                "numero_funcionario" => $faker->unique()->randomNumber(5, true),
                "numero_telefone" => $faker->phoneNumber(),
                "docente_id" => $docenteId,
            ]);
        }
    }

    public static function getEmailFromName($name)
    {
        return strtolower(str_replace(' ', '_', iconv('UTF-8', 'ASCII//TRANSLIT', $name))) .
            '@estga.pt';
    }
}
