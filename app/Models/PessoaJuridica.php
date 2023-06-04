<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use YourAppRocks\EloquentUuid\Traits\HasUuid;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PessoaJuridica extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'pessoas_juridicas';
    public $timestamps = false;
    protected $fillable = ['cnpj', 'razao_social', 'nome_representante'];

    /**
     * [Description for fornecedor]
     *
     * @return MorphOne
     * 
     */
    public function fornecedor():MorphOne
    {
        return $this->morphOne(Fornecedor::class, 'fornecedorable');
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
