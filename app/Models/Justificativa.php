<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use YourAppRocks\EloquentUuid\Traits\HasUuid;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Justificativa extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'justificativas';
    protected $fillable = ['texto', 'tipo', 'cotacao_id'];
    public $timestamps = false;

    public function cotacao(): BelongsTo
    {
        return $this->belongsTo(Cotacao::class, 'cotacao_id');
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
