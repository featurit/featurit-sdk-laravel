<?php

return [
    'tenant_identifier' => env('FEATURIT_TENANT_IDENTIFIER', ''),
    'environment_key' => env('FEATURIT_ENVIRONMENT_KEY', ''),

    'cache_ttl_minutes' => env('FEATURIT_CACHE_TTL_MINUTES', 5),

    'featurit_user_context_provider' => Featurit\Client\Laravel\Providers\LaravelFeaturitUserContextProvider::class,
];