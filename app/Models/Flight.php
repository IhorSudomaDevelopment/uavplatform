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
        'personnel_200',
        'personnel_300',
        'ammunition',
        'is_drone_lost',
        'drone_lost_reason',
    ];

    /*** @var string[] */
    protected $casts = ['status' => 'array', 'ammunition' => 'array'];

    /*** @return array */
    public function getStatus(): array
    {
        if (!is_array($this->status)) {
            $decodedStatus = (array)json_decode($this->status, true);
            if (empty($decodedStatus)) {
                return [$this->status];
            }
            return (array)json_decode($this->status, true);
        }
        return $this->status;
    }

    /**
     * @param array $status
     * @return void
     */
    public function setStatus(array $status): void
    {
        $this->status = $status;
    }

    /*** @return array */
    public function getAmmunition(): array
    {
        if (!is_array($this->ammunition)) {
            return (array)json_decode($this->ammunition, true);
        }
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
