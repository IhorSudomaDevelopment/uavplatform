<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 *
 */
class Log extends Model
{
    /*** @var string[] */
    protected $fillable = [
        'user_id',
        'model',
        'model_id',
        'action',
        'old_values',
        'new_values',
        'ip',
        'user_agent',
    ];

    /*** @var string[] */
    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];

    /*** @return BelongsTo */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
