<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Periodo extends Model
{
    use HasFactory;
    
    public function impedimentos(): HasMany {
        return $this->hasMany(Impedimento::class);
    }

    public function unidadesCurriculares(): HasMany {
        return $this->hasMany(UnidadeCurricular::class);
    }

    protected $table = 'periodos';

    protected $fillable = ['ano', 'semestre', 'data_inicial', 'data_final'];

}
