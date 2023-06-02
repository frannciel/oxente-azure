<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use YourAppRocks\EloquentUuid\Traits\HasUuid;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Uasg extends Model
{
    use HasFactory, HasUuid;
	protected $table = 'uasgs';
    protected $fillable = [ 'nome', 'codigo', 'email', 'telefone', 'cidade_id'];
    
    public function cidades():BelongsToMany
    {
        return $this->belongsToMany(Cidade::class, 'cidade_uasg', 'uasg_id', 'cidade_id')
            ->using(Participante::class)
            ->withPivot('item_id')
            ->withPivot('quantidade')
            ->withTimestamps();
    }

    public function itens():BelongsToMany
    {
        return $this->belongsToMany(Item::class, 'cidade_uasg', 'uasg_id','item_id')
            ->using(Participante::class)
            ->withPivot('cidade_id')
            ->withPivot('quantidade')
            ->withTimestamps();
    }

    public function telefones(): HasMany
    {
        return $this->hasMany(Telefone::class);
    }

    public function emails(): HasMany
    {
        return $this->hasMany(Email::class);
    }

    /**
     *  Método que retorna a cidade sede da uasg
     *
     * @return     <Objeto>  ( Cidade )
     */
    public function cidade()
    {
        return $this->belongsTo(Cidade::class, 'cidade_id', 'id');
    }
}
