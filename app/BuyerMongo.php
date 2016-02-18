<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class BuyerMongo extends Eloquent {

    protected $connection = 'mongoDB';

    protected $collection = 'buyer';

}
