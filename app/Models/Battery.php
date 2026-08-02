<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Battery extends Model
{
    use LogsActivity;

    /**
     * The attributes that are mass assignable.
     * @var array<int, string>
     */
    protected $fillable = [
        'position_id',
        'title',
        'capacity',
        'additional_info',
        'flights_quantity',
        'status',
    ];

    /*** @return BelongsTo */
    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }
}
