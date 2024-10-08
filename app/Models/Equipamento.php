<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipamento extends Model
{
    use HasFactory;

    protected $fillable = ['nome'];

    public function projetos()
    {
        return $this->belongsToMany(Projeto::class, 'projeto_equipamento')
                    ->withPivot('quantidade')
                    ->withTimestamps();
    }
}
