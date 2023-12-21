<?php

namespace Database\Seeders;

use App\Models\Docente;
use Illuminate\Database\Seeder;

class DocentesTableSeeder extends Seeder
{
    public function run(): void
    {
        Docente::factory(20)->create();
    }
}
