<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Curso extends Model
{
    use HasFactory;

    public function unidadesCurriculares(): BelongsToMany {
        return $this->belongsToMany(UnidadeCurricular::class, 'cursos_unidades_curriculares')
                    ->withTimestamps();
    }

    protected $table = 'cursos';

    protected $fillable = ['nome','sigla'];
}
