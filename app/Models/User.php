<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Model implements Authenticatable
{
    use HasFactory;
    use AuthenticatableTrait;

    public function docente(): BelongsTo
    {
        return $this->belongsTo(Docente::class);
    }

    protected $fillable = [
        'nome',
        'email',
        'password',
        'admin',
        'numero_telefone',
        'numero_funcionario',
        'email_verificado_a',
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $casts = [
        'email_verificado_a' => 'datetime'
    ];
}
