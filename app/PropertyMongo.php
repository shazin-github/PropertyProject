<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class PropertyMongo extends Eloquent {


    protected $connection = 'mongoDB';

    protected $collection = 'property';

}
