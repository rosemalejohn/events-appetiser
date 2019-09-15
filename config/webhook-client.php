<?php

return [
    'configs' => [
        [
            'name' => 'default',
            'signing_secret' => env('WEBHOOK_CLIENT_SECRET', ''),
            'signature_header_name' => 'Signature',
            'signature_validator' => \App\Services\Webhook\WebhookValidator::class,
            'webhook_profile' => \Spatie\WebhookClient\WebhookProfile\ProcessEverythingWebhookProfile::class,
            'webhook_model' => \Spatie\WebhookClient\Models\WebhookCall::class,
            'process_webhook_job' => \App\Jobs\WebhookJob::class,
        ],
    ],
];
