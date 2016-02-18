<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class SellerMongo extends Eloquent {


    protected $connection = 'mongoDB';

    protected $collection = 'seller';

}

