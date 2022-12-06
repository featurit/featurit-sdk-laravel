# FeaturIT SDK for Laravel

Laravel wrapper of the PHP client for the FeaturIT Feature Flag management platform.

## Description

This package aims to simplify the integration of the FeaturIT API in a Laravel project.

## Getting started

### Dependencies

* PHP >= 8.0
* laravel/framework >= 5.1
* psr/http-client-implementation
* psr/simple-cache-implementation

### Installing

`composer require featurit/featurit-sdk-laravel`

If there's no package providing psr/http-client-implementation, 
visit https://packagist.org/providers/psr/http-client-implementation and choose the package
that better suits your project.

If there's no package providing psr/simple-cache-implementation,
visit https://packagist.org/providers/psr/simple-cache-implementation and choose the package
that better suits your project.

Inside your config/app.php file, in the providers array add:

```
        /*
         * Package Service Providers...
         */

        \Featurit\Client\Laravel\FeaturitServiceProvider::class,
```

If you want to publish the default configuration file in order to customize things 
like the default FeaturitUserContextProvider, use the following command:

`php artisan vendor:publish --provider="Featurit\Client\Laravel\FeaturitServiceProvider"`

### Usage

```
if (Featurit::isActive('YOUR_FEATURE_NAME')) {
    your_feature_code();
}
```

### Authors

FeaturIT

https://www.featurit.com

featurit_tech@gmail.com