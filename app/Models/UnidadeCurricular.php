<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class UnidadeCurricular extends Model
{
    use HasFactory;

    public function periodo(): BelongsTo {
        return $this->belongsTo(Periodo::class);
    }

    public function acn(): BelongsTo {
        return $this->belongsTo(ACN::class);
    }

    public function docentes(): BelongsToMany {
        return $this->belongsToMany(Docente::class, 'docentes_unidades_curriculares')
                ->withTimestamps();
    }

    public function docenteResponsavel(): BelongsTo {
        return $this->belongsTo(Docente::class, 'docente_responsavel_id');
    }

    public function cursos(): BelongsToMany {
        return $this->belongsToMany(Curso::class, 'cursos_unidades_curriculares')
                ->withTimestamps();
    }

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
