<?php

namespace Database\Seeders;

use App\Models\Curso;
use Illuminate\Database\Seeder;

class CursosTableSeeder extends Seeder
{
    public function run(): void
    {
        //Lista exemplo de cursos
        $cursos = [
            ['nome' => 'Eletrónica e Mecânica Industrial', 'sigla' => 'EMI'],
            ['nome' => 'Gestão Comercial', 'sigla' => 'GC'],
            ['nome' => 'Gestão da Qualidade', 'sigla' => 'GQ'],
            ['nome' => 'Gestão Pública', 'sigla' => 'GP'],
            ['nome' => 'Secretariado e Comunicação Empresarial', 'sigla' => 'SCE'],
            ['nome' => 'Tecnologias da Informação', 'sigla' => 'TI'],
        ];

        foreach ($cursos as $curso) {
            Curso::factory()->create($curso);
        }
    }
}
