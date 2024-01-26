<?php

namespace Database\Seeders;

use App\Models\ACN;
use Illuminate\Database\Seeder;

class ACNsTableSeeder extends Seeder
{
    public function run(): void
    {
        $acns = [
            ['nome' => 'Línguas', 'sigla' => 'L'],
            ['nome' => 'Informática', 'sigla' => 'I'],
            ['nome' => 'Matemática', 'sigla' => 'M'],
            ['nome' => 'Engenharia Geográfica', 'sigla' => 'EGG'],
            ['nome' => 'Gestão', 'sigla' => 'GES'],
            ['nome' => 'Ciências Jurídicas', 'sigla' => 'CJ'],
            ['nome' => 'Secretariado e Comunicação Empresarial', 'sigla' => 'SCE'],
            ['nome' => 'Contabilidade', 'sigla' => 'C'],
            ['nome' => 'Ciências Sociais', 'sigla' => 'CS'],
            ['nome' => 'Economia', 'sigla' => 'E'],
            ['nome' => 'Ciências da Engenharia', 'sigla' => 'CENG'],
            ['nome' => 'Engenharia Mecânica', 'sigla' => 'EMEC'],
            ['nome' => 'Eletrotecnia', 'sigla' => 'ELE'],
            ['nome' => 'Física', 'sigla' => 'F'],
        ];

        foreach ($acns as $acn) {
            ACN::factory()->create($acn);
        }
    }
}
