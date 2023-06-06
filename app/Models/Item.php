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
            ->withPivot('ordem')
            ->withTimestamps();
    }

    public function fornecedores():BelongsToMany
    {
        return $this->belongsToMany(Fornecedor::class, 'fornecedor_item', 'item_id', 'fornecedor_id')
            ->withPivot('licitacao_id')
            ->withPivot('quantidade', 'valor', 'marca', 'modelo' )
            ->withTimestamps();
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
     * @Descrition Método que retorna as Uasg que são participantes do item.
     * 
     * @return <Collect> App\Uasg
     */
    public function participantes()
    {
        return $this->belongsToMany(Uasg::class, 'cidade_item_uasg', 'item_id', 'uasg_id')
            ->using(Participante::class)
            ->withPivot('cidade_id')
            ->withPivot('quantidade')
            ->withTimestamps();
    }

    /**
     * @Descrition Método que retorna as cidades onde os itens deverão ser entregues. 
     * Estás cidades estão relacionadas as unidades participantes e o ógão gereciador.
     * 
     * @return <Collect> App\Cidade
     */
    public function localEntrega(){
        return $this->belongsToMany(Cidade::class, 'cidade_item_uasg', 'item_id', 'cidade_id')
            ->using(Participante::class)
            ->withPivot('uasg_id')
            ->withPivot('quantidade')
            ->withTimestamps();
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
