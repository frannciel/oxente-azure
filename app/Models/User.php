<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use YourAppRocks\EloquentUuid\Traits\HasUuid;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasUuid;

    protected $uuidColumnName = 'uuid';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relação muito para muitos para um de requisitente com usuários,
     *  onde o usuário representa a entidade muitos
     * 
     * @return App\User
     */
    public function unidadeAdministrativa()
    {
       return $this->belongsTo(UnidadeAdministrativa::class, 'unidade_administrativas_id');
    }

    /**
     * Relacionamento one to one entre usuário definido como administrador
     */
    public function administrador(): HasOne
    {
        return $this->hasOne(Administrador::class);
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Requisicao::class);
    }
    
    /**
     * Relacionamento one to one entre usuário definido como agente de contratação
     */
    public function agenteContratacao(): HasOne
    {
        return $this->hasOne(AgenteContratacao::class);
    }
        
    /**
     * Relacionamento one to one entre usuário definido como agente de contratação
     * Requisitante é o servidor que requisita compra
     */
    public function requisitante(): HasOne
    {
        return $this->hasOne(Requisitante::class);
    }

    /**
    * Retorna todos os e-mails relacioando ao usuário
     */
    public function emails(): HasMany
    {
        return $this->hasMany(Email::class);
    }

    /**
     * Retorna todos os telefones relacioando ao usuário
     */
    public function telefones(): HasMany
    {
        return $this->hasMany(Telefone::class);
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
