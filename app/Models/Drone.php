<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 *
 */
class Drone extends Model
{
    /**
     * The attributes that are mass assignable.
     * @var array<int, string>
     */
    protected $fillable = [
        'position_id',
        'title',
        'serial_number',
        'starlink_serial_number',
        'kit',
        'password',
        'additional_info',
        'type',
        'status',
    ];

    /*** @return BelongsTo */
    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }
}
