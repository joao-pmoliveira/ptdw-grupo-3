<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Docente extends Model
{
    use HasFactory;

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function impedimentos(): HasMany
    {
        return $this->hasMany(Impedimento::class);
    }

    public function acn(): BelongsTo
    {
        return $this->belongsTo(ACN::class);
    }

    public function unidadesCurriculares(): BelongsToMany
    {
        return $this->belongsToMany(UnidadeCurricular::class, 'docentes_unidades_curriculares')
            ->withPivot('percentagem_semanal')
            ->withTimestamps();
    }

    public function ucsResponsavel(): HasMany
    {
        return $this->hasMany(UnidadeCurricular::class, 'docente_responsavel_id');
    }

    protected $table = 'docentes';

    protected $fillable = ['numero_funcionario', 'acn_id', 'numero_telefone'];
}
