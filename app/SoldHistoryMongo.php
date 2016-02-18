<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class SoldHistoryMongo extends Eloquent {


    protected $connection = 'mongoDB';

    protected $collection = 'sold_history';

}

