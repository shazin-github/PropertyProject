<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = 'location';

    protected $fillable = ['address', 'city', 'zip', 'state', 'country', 'latitude', 'longitude'];
}
