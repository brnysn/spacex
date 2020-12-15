<?php

namespace App\Listeners;

use App\Events\FetchSpacexApiFinishedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;


class LogApiListener
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
     * @param  FetchSpacexApiFinishedEvent  $event
     * @return void
     */
    public function handle(FetchSpacexApiFinishedEvent $event)
    {
        // Log the completed event
        // Custom Log path => storage/logs/fetchSpacex.log
        Log::channel('fetchSpacex')->info("Fetch & DB sync completed. JSON = " . $event->response);
    }
}
