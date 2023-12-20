<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Impedimento extends Model
{
    use HasFactory;

    protected $table = 'impedimentos';

    protected $fillable = ['periodo_id', 'docente_id', 'impedimentos', 'justificacao'];
}
