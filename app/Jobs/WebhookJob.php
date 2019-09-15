<?php

namespace App\Jobs;

use Spatie\WebhookClient\ProcessWebhookJob;

class WebhookJob extends ProcessWebhookJob
{
    /**
     * Handle incoming status update
     *
     * Receive App Store status payment update and process
     * @return void
     */
    public function handle()
    {
        return true;
    }
}
