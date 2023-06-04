<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use YourAppRocks\EloquentUuid\Traits\HasUuid;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UnidadeAdministrativa extends Model
{
    use HasFactory, HasUuid;
    protected $table = 'unidades_administrativas';

    protected $fillable = [
        'nome', 'sigla'
    ];

     /**
     * Get the a unidade administrativa tem muitos usuásrio 
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Retorna todos os e-mails relacioando ao setor
     */
    public function emails(): MorphMany
    {
        return $this->morphMany(Email::class, 'emailable');
    }

    /**
     * Retorna todos os telefones relacioando ao setor
     */
    public function telefones(): MorphMany
    {
        return $this->morphMany(Telefone::class, 'telefoneable');
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
