<?php

namespace Featurit\Client\Laravel\Facades;

use Featurit\Client\Modules\Segmentation\FeaturitUserContext;
use Illuminate\Support\Facades\Facade;

/**
 * @method static isActive(string $featureName): bool
 * @method static version(string $featureName): string
 * @method static setUserContext(FeaturitUserContext $featuritUserContext): void
 * @method static getUserContext(): FeaturitUserContext
 * @method static track(string $eventName, array $properties): void
 * @method static trackPerson(): void
 * @method static flush(): void
 */
class Featurit extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'featurit';
    }
}