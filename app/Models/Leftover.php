<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Leftover extends Model
{
    /**
     * The attributes that are mass assignable.
     * @var array<int, string>
     */
    protected $fillable = [
        'position_id',
        'title',
        'quantity',
        'unit',
        'leftover_on'
    ];

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }
}
