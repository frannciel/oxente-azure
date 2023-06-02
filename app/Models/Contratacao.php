<?php

namespace App\Models;

use App\Traits\DateTrait;
use Illuminate\Database\Eloquent\Model;
use YourAppRocks\EloquentUuid\Traits\HasUuid;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Contratacao extends Model
{
    use HasFactory, HasUuid, DateTrait;
    protected $table = 'contratacoes';

    protected $fillable = [
        'observacao', 'contrato', 'user_id', 'licitacao_id', 'fornecedor_id'
    ];

    /**
     * Metódo que retorna o usuário que solicitou a contratação
     * 
     * @return <Objeto>  App\User
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Método que retorna o fornecedor da contratação
     * @return <Objeto>  App\Fornecedor
     */
    public function fornecedor(): BelongsTo
    {
        return $this->belongsTo(Fornecedor::class, 'fornecedor_id');
    }
    /**
     * Método que retorna a licitação
     * @return <Objeto> App\Licitacao
     */
    public function licitacao(): BelongsTo
    {
        return $this->belongsTo(Licitacao::class, 'licitacao_id');
    }
    /**
     * Método que retorna os itens da contratação, com a quantidade contratada e o valor unitário atual
     * @return <Collect>  App\Item
     */
    public function itens(): BelongsToMany
    {
        return $this->belongsToMany(Item::class, 'contratacao_item', 'contratacao_id', 'item_id')
        	->withPivot(['quantidade', 'valor']);
    }

    public function getTotalAttribute()
    {
        $total = 0;
        foreach ($this->itens as $item) {
           $total += $item->pivot->quantidade * $item->pivot->valor;
        }
        return number_format($total, 2, ',', '.');
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
