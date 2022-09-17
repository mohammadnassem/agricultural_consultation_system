<?php

namespace App\Listeners;

use App\Event\humidityChange;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendHumidityNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Event\humidityChange  $event
     * @return void
     */
    public function handle(humidityChange $event)
    {
        //
    }
}
