<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use YourAppRocks\EloquentUuid\Traits\HasUuid;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fornecedor extends Model
{
    use  HasFactory, HasUuid;

    protected $table = 'fornecedores';
    protected $fillable = [
        'endereco', 'cep', 'cidade_id'
    ];

    /**
     * Retorna todos os e-mails relacioando ao fornecedor
     */
    public function emails(): HasMany
    {
        return $this->hasMany(Email::class);
    }

    /**
     * Retorna todos os telefones relacioando ao fornecedor
     */
    public function telefones(): HasMany
    {
        return $this->hasMany(Telefone::class);
    }

    /**
     * Relacionamento com as classes Pessoa Física e Pessoa Jurídica
     *
     * @return MorphTo
     * 
     */
    public function fornecedorable(): MorphTo
    {
        return $this->morphTo();
    }


    /**
     * Retorna o nome ou a razão social do fornecedor
     *
     * @return string Nome
     * 
     */
    public function getNomeAttribute(): string
    {
        if ($this->fornecedorable_type == 'Pessoa Física')
            return $this->fornecedorable->nome;
        if ($this->fornecedorable_type == 'Pessoa Jurídica')
            return $this->fornecedorable->razao_social;
    }

    /**
     * Retorna o número de inscrição CPF ou CNPJ de acordo com o tipo de fornecedor
     *
     * @return string inscricao
     * 
     */
    public function getCpfCnpjAttribute(): string
    {
        if ($this->fornecedorable_type == 'Pessoa Física')
            return $this->fornecedorable->cpf;
        if ($this->fornecedorable_type == 'Pessoa Jurídica')
            return $this->fornecedorable->cnpj;
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
