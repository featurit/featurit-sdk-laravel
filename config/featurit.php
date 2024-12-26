<?php

return [
    'tenant_identifier' => env('FEATURIT_TENANT_IDENTIFIER', ''),
    'environment_key' => env('FEATURIT_ENVIRONMENT_KEY', ''),
    'enable_analytics' => env('FEATURIT_ENABLE_ANALYTICS', false),
    'enable_tracking' => env('FEATURIT_ENABLE_TRACKING', false),
    'cache_ttl_minutes' => env('FEATURIT_CACHE_TTL_MINUTES', 5),
    'send_analytics_interval_minutes' => env('FEATURIT_SEND_ANALYTICS_INTERVAL_MINUTES', 1),
    'featurit_user_context_provider' => Featurit\Client\Laravel\Providers\LaravelFeaturitUserContextProvider::class,
];