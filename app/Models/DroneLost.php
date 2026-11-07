<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DroneLost extends Model
{
    use LogsActivity;

    /**
     * The attributes that are mass assignable.
     * @var array<int, string>
     */
    protected $fillable = [
        'drone_id',
        'drone_sn',
        'date',
        'time',
        'lost_coords',
        'lost_reason',
    ];

    /*** @return BelongsTo */
    public function drone(): BelongsTo
    {
        return $this->belongsTo(Drone::class);
    }
}
