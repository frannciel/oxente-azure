<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requisitante extends Model
{
    use HasFactory;

    /**
     * Get the user that owns the administrador.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
