<?php

namespace App\Models;

use App\Models\Item;
use App\Models\Contratacao;
use Illuminate\Database\Eloquent\Model;
use YourAppRocks\EloquentUuid\Traits\HasUuid;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Procedimento extends Model
{
    use HasFactory, HasUuid;
    protected $table = 'procedimentos';
    protected $fillable = [
        'uasg_id', 'numero', 'ano', 'objeto', 'processo', 'data_publicacao'
    ];

    public function procedimentoable(): MorphTo
    {
        return $this->morphTo();
    }

    public function itens():BelongsToMany
    {
        return $this->belongsToMany(Item::class, 'item_procedimento', 'procedimento_id', 'item_id')
            ->withPivot('ordem')
            ->withTimestamps();
    }
    public function contratacoes(): HasMany
    {
        return $this->hasMany(Contratacao::class);
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
        return date('d/m/Y', strtotime($this->attributes['data_publicacao']));
    }

    protected function setPublicacaoAttribute($value)
    {
        $this->attributes['data_publicacao'] = date_format(date_create(str_replace("/", "-", $value)), 'Y-m-d');
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
