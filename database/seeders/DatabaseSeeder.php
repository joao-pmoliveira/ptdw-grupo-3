<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        \App\Models\ACN::factory(11)->create();
        \App\Models\Curso::factory(11)->create();
        \App\Models\Docente::factory(11)->create();
        \App\Models\Periodo::factory(11)->create();
        \App\Models\Impedimento::factory(11)->create();
        \App\Models\UnidadeCurricular::factory(11)->create();
    }
}
