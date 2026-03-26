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
        'title',
        'serial_number',
        'kit',
        'password',
        'type',
        'status',
    ];
}
