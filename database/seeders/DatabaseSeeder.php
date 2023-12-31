<?php

namespace Database\Seeders;

use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(ACNsTableSeeder::class);
        $this->call(CursosTableSeeder::class);
        $this->call(PeriodosTableSeeder::class);

        $this->call(DocentesTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(ImpedimentosTableSeeder::class);

        $this->call(UnidadesCurricularesTableSeeder::class);
    }
}
