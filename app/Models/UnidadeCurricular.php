<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnidadeCurricular extends Model
{
    use HasFactory;

    protected $table = 'unidades_curriculares';

    protected $fillable = [
        'codigo',
        'periodo_id',
        'nome',
        'acn_id',
        'horas_semanais',
        'laboratorio',
        'software',
        'ects',
        'sala_avaliacao',
        'docente_responsavel_id',
        'percentagem_semanal'
    ];
}
