<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projeto extends Model
{
    use HasFactory;

    protected $fillable = ['cliente_id', 'localizacao_id', 'nome', 'tipo_instalacao_id'];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function localizacao()
    {
        return $this->belongsTo(Localizacao::class);
    }

    public function tipoInstalacao()
    {
        return $this->belongsTo(TipoInstalacao::class);
    }

    public function equipamentos()
    {
        return $this->belongsToMany(Equipamento::class, 'projeto_equipamento')
                    ->withPivot('quantidade')
                    ->withTimestamps();
    }
}
