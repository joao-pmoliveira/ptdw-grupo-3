<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Impedimento extends Model
{
    use HasFactory;

    public function docente(): BelongsTo
    {
        return $this->belongsTo(Docente::class);
    }

    public function periodo(): BelongsTo
    {
        return $this->belongsTo(Periodo::class);
    }

    protected $table = 'impedimentos';

    protected $fillable = [
        'periodo_id',
        'docente_id',
        'impedimentos',
        'justificacao',
        'submetido'
    ];
}
