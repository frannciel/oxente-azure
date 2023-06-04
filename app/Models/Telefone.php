<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use YourAppRocks\EloquentUuid\Traits\HasUuid;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Telefone extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'telefones';
    protected $fillable = ['numero', 'ramal', 'tipo', 'prioridade'];
     /**
     * Get the parent telefoneable model (User, Uadm, fornecedor or Uasg).
     */
    public function telefoneable(): MorphTo
    {
        return $this->morphTo();
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
