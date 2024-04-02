<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Callout extends Model
{
    use HasFactory;

     /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    protected $fillable = [
        'type',
        'title',
        'description',
        'location_string',
        'location_longitude',
        'location_latitude',
        'start_time',
        'end_time',
        'num_team_members',
    ];

}
