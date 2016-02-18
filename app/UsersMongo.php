<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class UsersMongo extends Eloquent {


    protected $connection = 'mongoDB';

    protected $collection = 'users';

}

