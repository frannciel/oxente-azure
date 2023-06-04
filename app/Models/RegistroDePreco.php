<?php

namespace App\Models;

use App\Traits\DateTrait;
use Illuminate\Database\Eloquent\Model;
use YourAppRocks\EloquentUuid\Traits\HasUuid;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class RegistroDePreco extends Model
{
    use HasFactory, HasUuid, DateTrait;

    protected $table = 'registros_precos';
    protected $fillable = [
        'numero', 'ano', 'assinatura','vigencia_inicio', 'vigencia_fim', 'licitacao_id', 'fornecedor_id', 
    ];

    public function fornecedor(): BelongsTo
    {
    	return $this->belongsTo(Fornecedor::class, 'fornecedor_id');
    }

    public function licitacao(): BelongsTo
    {
    	return $this->belongsTo(Licitacao::class, 'licitacao_id');
    }

    public function itens(): BelongsToMany
    {
        return $this->belongsToMany(Item::class, 'item_registro_precos', 'registro_precos_id', 'item_id');
    }

    public function setAssinaturaAttribute($value)
    {
       $this->attributes['assinatura'] = $this->setData($value);
    }

    public function getAssinaturaAttribute()
    {
        return $this->getData($this->attributes['assinatura']);
    }

     public function setVigenciaInicioAttribute($value)
    {
        $this->attributes['vigencia_inicio'] = $this->setData($value);
    }
    
    public function getVigenciaInicioAttribute()
    {
        return  $this->getData($this->attributes['vigencia_inicio']);
    }

    public function setVigenciaFimAttribute($value)
    {
        $this->attributes['vigencia_fim'] =  $this->setData($value);
    }
    
    public function getVigenciaFimAttribute()
    {
        return  $this->getData($this->attributes['vigencia_fim']);
    }
     
    protected function setData($value)
    {
        return date_format(date_create(str_replace("/", "-", $value)), 'Y-m-d');
    }

    protected function getData($value)
    {
        return date('d/m/Y', strtotime($value));
    }

    protected function getOrdemAttribute()
    {
        return $this->numero.'/'. $this->ano;
    }
}
