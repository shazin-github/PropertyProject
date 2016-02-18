<?php

namespace App\Listeners;

use App\Events\SaveListing;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Api\Criterias\CriteriasHandler;

class EventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
     protected $handler;
    public function __construct(CriteriasHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * Handle the event.
     *
     * @param  SaveListing  $event
     * @return void
     */
    public function handle(SaveListing $event)
    {
        $event->save_criteria($this->handler);

    }
}
