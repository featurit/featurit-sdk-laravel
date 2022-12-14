<?php

namespace Featurit\Client\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

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