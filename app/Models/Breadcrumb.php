<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Breadcrumb extends Model
{
    use HasFactory;

    protected $table = 'breadcrumbs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'route_name',
        'title',
        'has_parameters',
    ];

    public function children(): HasMany
    {
        return $this->hasMany(Breadcrumb::class, 'breadcrumb_id', 'id');
    }

    public function father(): BelongsTo
    {
        return $this->belongsTo(Breadcrumb::class, 'breadcrumb_id', 'id');
    }
}
