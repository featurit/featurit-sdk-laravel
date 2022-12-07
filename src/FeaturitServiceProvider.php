<?php

namespace Featurit\Client\Laravel;

use Featurit\Client\FeaturitBuilder;
use Illuminate\Support\ServiceProvider;
use ReflectionClass;

class FeaturitServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the configuration
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            $this->getConfigPath() => config_path('featurit.php')
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom($this->getConfigPath(), 'featurit');

        $this->app->singleton('featurit', function ($app) {

            $featuritUserContextProvider = config('featurit.featurit_user_context_provider');

            return (new FeaturitBuilder())
                ->setTenantIdentifier(config('featurit.tenant_identifier'))
                ->setApiKey(config('featurit.environment_key'))
                ->setCacheTtlMinutes(config('featurit.cache_ttl_minutes'))
                ->setFeaturitUserContextProvider(new $featuritUserContextProvider())
                ->build();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['featurit'];
    }

    /**
     * @return string
     */
    public function getConfigPath(): string
    {
        return __DIR__ . '/../config/featurit.php';
    }
}