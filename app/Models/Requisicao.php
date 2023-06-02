<?php

namespace App\Models;

use App\Traits\DateTrait;
use Illuminate\Database\Eloquent\Model;
use YourAppRocks\EloquentUuid\Traits\HasUuid;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Requisicao extends Model
{
    use HasFactory, HasUuid, DateTrait;
    protected $table = 'requisicoes';
    protected $fillable = [
        'numero', 'ano', 'descricao', 'tipo', 'prioridade', 'renovacao','pac', 'capacitacao', 'previsao', 'metas', 'justificativa', 'user_id','unidadeAdministrativa_id'
    ];

    public function itens(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    public function unidadeAdministrativa(): BelongsTo
    {
       return $this->belongsTo(UnidadeAdministrativa::class, 'unidadeAdministrativa_id');
    }

    public function requisitante(): HasOne
    {
       return $this->hasOne(User::class, 'user_id');
    }

    /*public function licitacoes():BelongsToMany
    {
        return $this->belongsToMany(Licitacao::class, 'licitacao_requisicao');
    }*/

    public function getValorTotalAttribute()
    {
        return number_format($this->total, 2, ',', '.');
    }

    public function getTotalAttribute()
    {
        $soma = 0;
        foreach ( $this->itens as  $item) 
            $soma += $item->total;
        return $soma;
    }

    protected function getOrdemAttribute()
    {
        return $this->numero.'/'. $this->ano;
    }

    protected function getPrevisaoAttribute()
    {
        if ($this->attributes['previsao'] == "0000-00-00") {
            return '';
        } else{
            return date('d/m/Y', strtotime($this->attributes['previsao']));
        }
    }

    public function setDataAttribute($value)
    {
        $this->attributes['previsao'] = date_format(date_create(str_replace("/", "-", $value)), 'Y-m-d');
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

