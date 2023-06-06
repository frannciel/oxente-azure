<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use YourAppRocks\EloquentUuid\Traits\HasUuid;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Uasg extends Model
{
    use HasFactory, HasUuid;
	protected $table = 'uasgs';
    protected $fillable = [ 'nome', 'codigo', 'cidade_id'];
    
    public function unidadesAdministrativas(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    public function cidade():BelongsTo
    {
        return $this->belongsTo(Cidade::class, 'cidade_id');
    }

    public function cidades():BelongsToMany
    {
        return $this->belongsToMany(Cidade::class, 'cidade_item_uasg', 'uasg_id', 'cidade_id')
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

    /**
     * Retorna todos os e-mails relacioando à uasg.
     */
    public function emails(): MorphMany
    {
        return $this->morphMany(Email::class, 'emailable');
    }

    /**
     * Retorna todos os telefones relacioando à uasg.
     */
    public function telefones(): MorphMany
    {
        return $this->morphMany(Telefone::class, 'telefoneable');
    }
}
