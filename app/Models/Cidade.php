<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use YourAppRocks\EloquentUuid\Traits\HasUuid;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Cidade extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'cidades';
	protected $fillable = ['nome', 'estado_id'];

    public function estado():BelongsTo
    {
        return $this->belongsTo(Estado::class, 'estado_id');
    }

    public function fornecedores():HasMany
    {
        return $this->hasMany(Fornecedor::class);
    }

    /**
     * Retorna as uasgs que são sediadas na cidade
     *
     * @return   
     */
    public function uasgs():HasMany
    {
        return $this->hasMany(Uasg::class);
    }

     /**
     * Retorna as Unidade Administrativas do Serviços Gerais (UASG) definiram a cidade como local de entrega em participações de pregões eletrônicos SRP.
     *
     * @return BelongsToMany
     */
    public function participantes():BelongsToMany
    {
        return $this->belongsToMany(Uasg::class, 'cidade_item_uasg','cidade_id', 'uasg_id')
            ->using(Participante::class)
            ->withPivot('item_id')
            ->withPivot('quantidade')
            ->withTimestamps();
    }
	
    /**
     * Método que permite retorna todos os itens decorrentes de participações em pregões eletrônicos SRP que tiveram a cidade
     * como local de entrega.
     *
     * @return     <Collect>  (Item)
     */
	public function itens():BelongsToMany
    {
        return $this->belongsToMany(Item::class, 'cidade_uasg','cidade_id', 'item_id')
            ->using(Participante::class)
            ->withPivot('uasg_id')
            ->withPivot('quantidade')
            ->withTimestamps();
    }

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
}
