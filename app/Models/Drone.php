<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
