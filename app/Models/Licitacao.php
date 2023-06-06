<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use YourAppRocks\EloquentUuid\Traits\HasUuid;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Licitacao extends Model
{
    use HasFactory, HasUuid;
    protected $table = 'licitacoes';
    protected $fillable = [
        'uasg_id', 'numero', 'ano', 'objeto', 'processo', 'data_publicacao',
    ];

    public function licitacaoable(): MorphTo
    {
        return $this->morphTo();
    }

    public function itens():BelongsToMany
    {
        return $this->belongsToMany(Item::class, 'item_licitacao', 'licitacao_id', 'item_id')
            ->withPivot('ordem')
            ->withTimestamps();
    }
    /*
    public function requisicoes():BelongsToMany
    {
        return $this->belongsToMany(Requisicao::class, 'licitacao_requisicao')
            ->withTimestamps();
    }*/

    public function contratacoes(): HasMany
    {
        return $this->hasMany(Contratacao::class);
    }

    public function registroDePrecos():HasMany
    {
        return $this->hasMany(RegistroDePreco::class);
    }

	public function uasg():BelongsTo
	{
		return $this->belongsTo(Uasg::class, 'uasg_id');
	}

    /**
     * Metodo que retorna a collection de itens mesclados da licitação
     *
     * @return  Collection  $item
     */
    public function mesclados(): BelongsToMany
    {
        return $this->belongsToMany(Item::class, 'mesclados', 'licitacao_id', 'mesclado_id')
            ->withPivot('item_id');
    }

    protected function getOrdemAttribute():string
    {
        return $this->numero.'/'. $this->ano;
    }

    public function getValorTotalEstimadoAttribute():string
    {
        return number_format($this->totalEstimado, 2, ',', '.');
    }

    public function getTotalEstimadoAttribute(): float
    {
        $soma = 0;
        foreach ( $this->itens as  $item) 
            $soma += $item->totalGeral;
        return $soma;
    }

    protected function getPublicacaoAttribute():string
    {
        return date('d/m/Y', strtotime($this->attributes['publicacao']));
    }

    protected function setPublicacaoAttribute($value)
    {
        $this->attributes['publicacao'] = date_format(date_create(str_replace("/", "-", $value)), 'Y-m-d');
    }

    /**
     * Get the route key for the model. 
     * Método para definir a chave usada na injeção de dependêcia dos model através das rotas
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
