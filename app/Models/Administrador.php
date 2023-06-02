<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Administrador extends Model
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
