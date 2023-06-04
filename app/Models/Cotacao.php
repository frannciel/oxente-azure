<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use YourAppRocks\EloquentUuid\Traits\HasUuid;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cotacao extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'cotacoes';
    protected $fillable = [
        'fonte', 'valor', 'data', 'parametro', 'is_valido', 'item_id'
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function justificativas(): HasMany
    {
        return $this->hasMany(Justificativa::class);
    }

    /**
     * Método que retona a hora da cotação
     *
     * @return     <String>  The hora attribute.
     */
    public function getHoraAttribute()
    {
        return date('H:i', strtotime(str_replace("/", "-", $this->data)));
    }

    public function getDataAttribute($value)
    {
        if ($value == NULL) {
            return $value = '--/--/----';
        } elseif(date('H:i', strtotime($value)) == '00:00'){
            return date('d/m/Y', strtotime($value));
        } else {
            return date('d/m/Y H:i', strtotime($value));
        } 
    }

    /**
     * Retorna o valor da cotação em formato de moeda 0.000,00
     *
     * @return string
     * 
     */
    public function getContabilAttribute(): string
    {
        return number_format($this->valor, 2, ',', '.');
    }
    
    public function setDataAttribute($value)
    {
        if ($value == NULL) {
            $this->attributes['data'] = NULL;
        } else {
            $this->attributes['data'] = date_format(date_create(str_replace("/", "-", $value)), 'Y-m-d H:i:s');
        }
    }

    /**
     * Método que converte o valor do tipo sring para tipo Float antes da inserção no banco de dados
     *
     * @param mixed $value
     * 
     */
    public function setValorAttribute($value)
    { 
        if(strstr($value, ",")) 
            $value = str_replace(",", ".", str_replace(".", "", $value)); // remove o ponto e em seguida convert virgula em ponto
    
        if(preg_match("#([0-9\.]+)#", $value, $match)) {
            $this->attributes['valor'] = floatval($match[0]); 
        } else { 
            $this->attributes['valor'] = floatval($value); 
        }
    }

    /**
     * Compara os parametro de duas cotações verificado sem ambos são iguais e retona um boolaen
     *
     * @param Cotacao $cotacao
     * @return bool
     * 
     */
    public function equals(Cotacao $outro): bool
    {
        return $outro instanceof $this && $outro->hashCode == $this->hashCode;
    }

    public function getHashCodeAttribute(): string
    {
        return hash('md5',$this->item_id.$this->fonte.$this->valor.$this->data.$this->parametro);
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
