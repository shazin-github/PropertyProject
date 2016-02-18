<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class AgentMongo extends Eloquent {

    protected $connection = 'mongoDB';

    protected $collection = 'agent';

}
