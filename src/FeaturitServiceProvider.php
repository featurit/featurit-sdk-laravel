<?php

namespace Featurit\Client\Laravel;

use Featurit\Client\FeaturitBuilder;
use Featurit\Client\Laravel\Facades\Featurit;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

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

        $this->registerBladeCustomIfStatementsAndDirectives();
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
                ->setIsAnalyticsModuleEnabled(config('featurit.enable_analytics'))
                ->setCacheTtlMinutes(config('featurit.cache_ttl_minutes'))
                ->setSendAnalyticsIntervalMinutes(config('featurit.send_analytics_interval_minutes'))
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

    /**
     * @return void
     */
    private function registerBladeCustomIfStatementsAndDirectives(): void
    {
        Blade::if('ifFeatureIsActive', function (string $feature) {
            return Featurit::isActive($feature);
        });

        Blade::if('ifFeatureIsNotActive', function (string $feature) {
            return !Featurit::isActive($feature);
        });

        Blade::if('ifFeatureVersionEquals', function (string $feature, string $value) {
            return Featurit::version($feature) == $value;
        });
    }
}