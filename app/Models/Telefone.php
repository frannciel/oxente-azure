<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use YourAppRocks\EloquentUuid\Traits\HasUuid;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Telefone extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'telefones';

    protected $fillable = ['email', 'prioridade'];
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

    /**
     * [Description for user]
     *
     * @return BelongsTo
     * 
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * [Description for unidadeAdministrativa]
     *
     * @return BelongsTo
     * 
     */
    public function unidadeAdministrativa(): BelongsTo
    {
        return $this->belongsTo(UnidadeAdministrativa::class);
    }

    /**
     * [Description for user]
     *
     * @return BelongsTo
     * 
     */
    public function Uasg(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


}
