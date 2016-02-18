<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Api\Criterias\CriteriasHandler;
use App\Api\Helper\GroupsHelper;


class SaveListing extends Event
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    protected $data;
    protected $criteria_helper;
  
    public function __construct($data, GroupsHelper $criteria_helper)
    {
        $this->criteria_helper = $criteria_helper;
        $this->data = $data;
       

    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
    //one simple function just to save 
    public function save_criteria(CriteriasHandler $handler){
        $this->criteria_helper->insert_listing($this->data);
        return $response = $handler->save_criteria($this->data);
    }
}
