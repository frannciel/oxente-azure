<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use YourAppRocks\EloquentUuid\Traits\HasUuid;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pregao extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'pregoes';
    protected $fillable = [ 'tipo', 'forma', 'is_srp' ];

    public function licitacao():MorphOne
    {
        return $this->morphOne(Licitacao::class, 'licitacaoable');
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }
}
