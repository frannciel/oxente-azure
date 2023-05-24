<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use YourAppRocks\EloquentUuid\Traits\HasUuid;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasUuid;

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
    
    /**
     * Relacionamento one to one entre usuário definido como agente de contratação
     */
    public function agenteContratacao(): HasOne
    {
        return $this->hasOne(AgenteContratacao::class);
    }
        
    /**
     * Relacionamento one to one entre usuário definido como agente de contratação
     */
    public function requisitante(): HasOne
    {
        return $this->hasOne(Requisitante::class);
    }
}
