<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use YourAppRocks\EloquentUuid\Traits\HasUuid;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Estado extends Model
{
    use HasFactory, HasUuid;
   	protected $table = 'estados';

	protected $fillable = ['codigo_ibge', 'nome', 'sigla' ];

    /**
     * Get the route key for the model. 
     * Método para definir a chave usada na injeção de dependêcia dos model através das rotas
     *
     * @return string uuid
     */
    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function cidades(): HasMany
    {
        return $this->hasMany(Cidade::class);
    }

    /**
     * Retorna todas as unidades de serviços gerais cadastradas como de determinado estado
     *
     * @return HasManyThrough
     * 
     */
    public function uasgs():HasManyThrough
    {
        return $this->hasManyThrough('App\Uasg', 'App\Cidade',
            'estado_id', // Foreign key on cidades table...
            'cidade_id', // Foreign key on uasgs table...
            'id', // Local key on estados table...
            'id' // Local key on cidades table...
        );
    }

    /**
     * Retorna todas os fonecedores cadastrados de determinado estado
     *
     * @return HasManyThrough
     * 
     */
    public function fornecedores():HasManyThrough
    {
        return $this->hasManyThrough(Fornecedor::class, Cidade::class,
            'estado_id', // Foreign key on cidades table...
            'cidade_id', // Foreign key on fornecedor table...
            'id', // Local key on estados table...
            'id' // Local key on cidades table...
        );
    }
}