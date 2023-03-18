<?php

namespace Featurit\Client\Larvel\Tests;

use Featurit\Client\Laravel\Facades\Featurit;
use Featurit\Client\Laravel\FeaturitServiceProvider;
use Featurit\Client\Modules\Segmentation\DefaultFeaturitUserContext;
use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;
use Orchestra\Testbench\TestCase;

class FeaturitServiceProviderTest extends TestCase
{
    use InteractsWithViews;

    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return array<int, class-string>
     */
    protected function getPackageProviders($app)
    {
        return [
            FeaturitServiceProvider::class,
        ];
    }

    public function test_facade_can_be_resolved()
    {
        $isFeatureFlagActive = Featurit::isActive('TEST_FEATURE');

        $this->assertFalse($isFeatureFlagActive);
    }

    public function test_version_can_be_called()
    {
        $featureFlagVersion = Featurit::version('TEST_FEATURE');

        $this->assertEquals('default', $featureFlagVersion);
    }

    public function test_setUserContext_can_be_called()
    {
        Featurit::setUserContext(
            new DefaultFeaturitUserContext(
                "1234",
                "ab12bb8",
                "192.168.1.1",
                [
                    "role" => "ADMIN"
                ]
            )
        );

        $this->assertEquals("1234", Featurit::getUserContext()->getUserId());
        $this->assertEquals("ADMIN", Featurit::getUserContext()->getCustomAttribute("role"));
    }

    public function test_service_name_is_provided()
    {
        $this->assertArrayHasKey('featurit', $this->app->getBindings());
    }

    public function test_blade_directives_are_published()
    {
        $view = $this->blade("<div>
            @ifFeatureIsActive('TEST_FEATURE')
                content
            @endifFeatureIsActive
        </div>");

        $view->assertDontSee('content');

        $view = $this->blade("<div>
            @ifFeatureIsNotActive('TEST_FEATURE')
                content
            @endifFeatureIsNotActive
        </div>");

        $view->assertSee('content');

        $view = $this->blade("<div>
            @ifFeatureVersionEquals('TEST_FEATURE', 'v1')
                content
            @endifFeatureVersionEquals
        </div>");

        $view->assertDontSee('content');
    }
}
