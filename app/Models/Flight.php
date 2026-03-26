<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 *
 */
class Flight extends Model
{
    /**
     * The attributes that are mass assignable.
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'position',
        'flight_number',
        'date',
        'time_start',
        'time_end',
        'target',
        'coordinates',
        'status',
        'ammunition',
    ];

    /*** @var string[] */
    protected $casts = ['ammunition' => 'array'];

    /*** @return array */
    public function getAmmunition(): array
    {
        return $this->ammunition;
    }

    /**
     * @param array $ammunition
     * @return void
     */
    public function setAmmunition(array $ammunition): void
    {
        $this->ammunition = $ammunition;
    }
}
