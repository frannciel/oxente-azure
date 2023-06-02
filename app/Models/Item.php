<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use YourAppRocks\EloquentUuid\Traits\HasUuid;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Item extends Model
{
    use HasFactory, HasUuid;
    
    protected $table = 'itens';
    protected $fillable = [
        'numero',  'quantidade', 'codigo', 'objeto', 'descricao', 'unidade_id', 'requisicao_id', 'grupo_id'
    ];

    public function unidade(): BelongsTo
    {
        return $this->belongsTo(Unidade::class, 'unidade_id');
    }

    public function requisicao(): BelongsTo
    {
        return $this->belongsTo(Requisicao::class, 'requisicao_id');
    }

    public function grupo(): BelongsTo
    {
        return $this->belongsTo(Grupo::class, 'grupo_id');
    }

    public function licitacoes(): BelongsToMany
    {
        return $this->belongsToMany(Licitacao::class, 'item_licitacao', 'item_id', 'licitacao_id')
            ->withPivot('ordem');
    }

    public function cotacoes(): HasMany
    {
        return $this->hasMany(Cotacao::class);
    }

    public function registrosDePrecos(): BelongsToMany
    {
        return $this->belongsToMany(RegistroDePreco::class, 'item_registro_precos', 'item_id', 'registro_precos_id');
    }

    /**
     * Retorna a contratação, com a quantidade contratada e o valor unitário atual
     *
     * @return BelongsToMany
     * 
     */
    public function contratacoes():BelongsToMany
    {
        return $this->belongsToMany(Contratacao::class, 'contratacao_item', 'contratacao_id', 'item_id')
            ->withPivot(['quantidade', 'valor', 'fornecedor_id']);
    }

    /**
     * Get the route key for the model. 
     * Método para definir a chave usada na injeção de dependêcia dos model através das rotas
     *
     * @return string
     */
    public function getRouteKeyName():string
    {
        return 'uuid';
    }
}
