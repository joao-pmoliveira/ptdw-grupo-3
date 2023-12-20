<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ACN extends Model
{
    use HasFactory;

    protected $table = 'acns';

    protected $fillable = ['nome', 'sigla'];
}
