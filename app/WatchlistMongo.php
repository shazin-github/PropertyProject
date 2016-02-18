<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class WatchlistMongo extends Eloquent {


    protected $connection = 'mongoDB';

    protected $collection = 'watchlist';

}

