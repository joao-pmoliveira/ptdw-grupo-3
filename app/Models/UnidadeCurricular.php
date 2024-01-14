<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class UnidadeCurricular extends Model
{
    use HasFactory;

    public function periodo(): BelongsTo
    {
        return $this->belongsTo(Periodo::class);
    }

    public function acn(): BelongsTo
    {
        return $this->belongsTo(ACN::class);
    }

    public function docentes(): BelongsToMany
    {
        return $this->belongsToMany(Docente::class, 'docentes_unidades_curriculares')
            ->withPivot('percentagem_semanal')
            ->withTimestamps();
    }

    public function docenteResponsavel(): BelongsTo
    {
        return $this->belongsTo(Docente::class, 'docente_responsavel_id');
    }

    public function cursos(): BelongsToMany
    {
        return $this->belongsToMany(Curso::class, 'cursos_unidades_curriculares')
            ->withTimestamps();
    }

    protected $table = 'unidades_curriculares';

    protected $fillable = [
        'codigo',
        'sigla',
        'periodo_id',
        'nome',
        'acn_id',
        'horas_semanais',
        'ects',
        'docente_responsavel_id',
        'restricoes_submetidas',
        'sala_laboratorio',
        'exame_final_laboratorio',
        'exame_recurso_laboratorio',
        'observacoes_laboratorios',
        'software',
    ];
}
