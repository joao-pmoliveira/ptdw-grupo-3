<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ACN extends Model
{
    use HasFactory;

    public function unidadesCurriculares(): HasMany {
        return $this->hasMany(UnidadeCurricular::class);
    }

    public function docentes(): HasMany {
        return $this->hasMany(Docente::class);
    }

    protected $table = 'acns';

    protected $fillable = ['nome', 'sigla'];
}
