<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class LocationMongo extends Eloquent {


    protected $connection = 'mongoDB';

    protected $collection = 'location';

}

