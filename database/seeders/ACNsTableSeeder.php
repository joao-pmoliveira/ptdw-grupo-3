<?php

namespace Database\Seeders;

use App\Models\ACN;
use Illuminate\Database\Seeder;

class ACNsTableSeeder extends Seeder
{
    public function run(): void
    {
        //Lista exemplo de áreas científicas
        $acns = [
            ['nome' => 'Informática', 'sigla' => 'I'],
            ['nome' => 'Física', 'sigla' => 'F'],
            ['nome' => 'Matemática', 'sigla' => 'M'],
            ['nome' => 'Química', 'sigla' => 'Q'],
            ['nome' => 'Biologia', 'sigla' => 'B'],
            ['nome' => 'Gestão', 'sigla' => 'GES'],
            ['nome' => 'Línguas', 'sigla' => 'L'],
        ];

        foreach ($acns as $acn) {
            ACN::factory()->create($acn);
        }
    }
}
