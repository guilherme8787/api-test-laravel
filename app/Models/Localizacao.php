<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Localizacao extends Model
{
    use HasFactory;

    protected $fillable = ['uf'];

    public function projetos()
    {
        return $this->hasMany(Projeto::class);
    }
}
