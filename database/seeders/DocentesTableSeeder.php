<?php

namespace Database\Seeders;

use App\Models\Docente;
use App\Models\UnidadeCurricular;
use Illuminate\Database\Seeder;

class DocentesTableSeeder extends Seeder
{
    public function run(): void
    {
        Docente::factory(11)->create();
    }
}
