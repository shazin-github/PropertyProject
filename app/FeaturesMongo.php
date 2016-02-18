<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class FeaturesMongo extends Eloquent {


    protected $connection = 'mongoDB';

    protected $collection = 'features';

}
