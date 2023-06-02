<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use YourAppRocks\EloquentUuid\Traits\HasUuid;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Grupo extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = [
        'numero', 'descricao'
    ];

    /**
     * Relaciomannto muitos para um com itens
     *
     * @return HasMany
     * 
     */
    public function itens(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    /**
     * Get the route key for the model. 
     * Método para definir a chave usada na injeção de dependêcia dos model através das rotas
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

}
