<?php

namespace Featurit\Client\Larvel\Tests;

use Featurit\Client\Laravel\Facades\Featurit;
use Featurit\Client\Laravel\FeaturitServiceProvider;
use Illuminate\Config\Repository;
use Illuminate\Foundation\Application;
use PHPUnit\Framework\TestCase;

class FeaturitServiceProviderTest extends TestCase
{
    public function setUp(): void
    {
        if (!class_exists(Application::class)) {
            $this->markTestSkipped();
        }

        parent::setUp();
    }

    public function test_facade_can_be_resolved()
    {
        $app = $this->setupApplication();
        $this->setupServiceProvider($app);

        // Mount facades
        Featurit::setFacadeApplication($app);

        $isFeatureFlagActive = Featurit::isActive('TEST_FEATURE');

        $this->assertFalse($isFeatureFlagActive);
    }

    public function test_service_name_is_provided()
    {
        $app = $this->setupApplication();
        $provider = $this->setupServiceProvider($app);

        $this->assertContains('featurit', $provider->provides());
    }

    /**
     * @param Application $app
     *
     * @return FeaturitServiceProvider
     */
    private function setupServiceProvider(Application $app): FeaturitServiceProvider
    {
        // Create and register the provider.
        $provider = new FeaturitServiceProvider($app);
        $app->register($provider);
        $provider->boot();

        return $provider;
    }

    /**
     * @return Application
     */
    protected function setupApplication(): Application
    {
        // Create the application such that the config is loaded.
        $app = new Application();
        $app->setBasePath(sys_get_temp_dir());

        $configRepository = new Repository();

        $app->instance('config', $configRepository);

        return $app;
    }
}
