<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Participante extends Pivot
{
    protected $table = 'cidade_uasg';

	/**
	 * Método que retorna um objeto cidade na relação ternária Item Cidade Uasg
	 *
	 * @return  Cidade
	 */
	public function cidade():BelongsTo
	{
		return $this->belongsTo(Cidade::class, 'cidade_id');
	}

	/**
	 * Método que retorna um objeto item na relação ternária Item Cidade Uasg
	 *
	 * @return  Item
	 */
	public function item():BelongsTo
	{
		return $this->belongsTo(Item::class, 'item_id');
	}

	/**
	 * Método que retorna um objeto uasg na relação ternária Item Cidade Uasg
	 *
	 * @return  Uasg
	 */
	public function uasg():BelongsTo
	{
		return $this->belongsTo(Uasg::class, 'uasg_id');
	}
}
