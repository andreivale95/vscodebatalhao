<?php

namespace App\Listeners;

use App\Events\ChegueiA10Pessoas;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class MandaUmEmailQualquer implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ChegueiA10Pessoas $event): void
    {
        logger('mandei um email: ' . __CLASS__ );
    }
}
