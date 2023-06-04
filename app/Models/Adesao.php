<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use YourAppRocks\EloquentUuid\Traits\HasUuid;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Adesao extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'adesoes';
    protected $fillable = [ 
        'tipo', 'forma', 'origem_uasg_id', 'origem_processo'
    ];

    public function licitacao(): MorphOne
    {
        return $this->morphOne(Licitacao::class, 'licitacaoable');
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    	/**
	 * Retorna um objeto uasg na relação ternária Item Cidade Uasg
	 *
	 * @return  Uasg
	 */
	public function uasgOrigem():BelongsTo
	{
		return $this->belongsTo(Uasg::class, 'origem_uasg_id');
	}
}
