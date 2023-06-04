<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use YourAppRocks\EloquentUuid\Traits\HasUuid;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inexigibilidade extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'inexigibilidades';
    protected $fillable = [ 'enquadramento', 'justificativa' ];

    public function licitacao():MorphOne
    {
        return $this->morphOne(Procedimento::class, 'procedimentoable');
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }
}
