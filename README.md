# FeaturIT SDK for Laravel

Laravel wrapper of the PHP client for the FeaturIT Feature Flag management platform.

## Description

This package aims to simplify the integration of the FeaturIT API in a Laravel project.

## Getting started

### Dependencies

* PHP >= 8.0.2
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

        Featurit\Client\Laravel\FeaturitServiceProvider::class,
```

If you want to publish the default configuration file in order to customize things 
like the default FeaturitUserContextProvider, use the following command:

`php artisan vendor:publish --provider="Featurit\Client\Laravel\FeaturitServiceProvider"`

### Basic Usage

That's how you would use Featurit in one of your controllers, services, or anywhere inside
your PHP codebase:

```
if (Featurit::isActive('YOUR_FEATURE_NAME')) {
    your_feature_code();
}
```

Or in order to check which is the version of your feature:

```
if (Featurit::version('YOUR_FEATURE_NAME') == 'v1') {
    your_feature_code_for_v1();
} else if (Featurit::version('YOUR_FEATURE_NAME') == 'v2') {
    your_feature_code_for_v2();
}
```

### Blade directives

For convenience we provide 3 blade directives which allow to load blade components depending on the Feature Flag values.

Inside your blade template, you can use them like this:

```
<div>
    <h2>This code will always be visible</h2>

    @ifFeatureIsActive('MY_ACTIVE_FEATURE')
        <h2>This will be visible</h2>
    @endifFeatureIsActive

    @ifFeatureIsNotActive('MY_ACTIVE_FEATURE')
        <h2>This will NOT be visible</h2>
    @endifFeatureIsNotActive
    
    @ifFeatureVersionEquals('FEATURE_WITH_VERSIONS', 'v1')
        <h2>Welcome to v1!</h2>
    @endifFeatureVersionEquals
    
    @ifFeatureVersionEquals('FEATURE_WITH_VERSIONS', 'v2')
        <h2>Welcome to v2!</h2>
    @endifFeatureVersionEquals
</div>
```

### Defining your FeaturitUserContext

In order to show different versions of a feature to different users,
Featurit needs to know about the attributes your user has in a certain context.

You can define the context using the as follows:

```
$contextData = get_your_user_context_data();

Featurit::setUserContext(
    new DefaultFeaturitUserContext(
        $contextData['userId'],
        $contextData['sessionId'],
        $contextData['ipAddress'],
        [
            'role' => $contextData['role'],
            ...
        ]
    )
);
```

### Defining a custom FeaturitUserContextProvider

This is an alternative to using `Featurit::setUserContext(...);`.

By default, Featurit SDK for Laravel comes with a default FeaturitUserContextProvider in 
your config/featurit.php file

```
'featurit_user_context_provider' => Featurit\Client\Laravel\Providers\LaravelFeaturitUserContextProvider::class,
```

But you can create your own implementation in order to add custom attributes so they can be used
in the segmentation process.

Let's say that your platform users have a "role" attribute that you use to decide which features 
you show to each user. In that case you could create an implementation like:

```
<?php

namespace My\Namespace\Of\Choice;

use Featurit\Client\Modules\Segmentation\DefaultFeaturitUserContext;
use Featurit\Client\Modules\Segmentation\FeaturitUserContext;
use Featurit\Client\Modules\Segmentation\FeaturitUserContextProvider;
use Illuminate\Support\Facades\Auth;

class MyCustomFeaturitUserContextProvider implements FeaturitUserContextProvider
{
    public function getUserContext(): FeaturitUserContext
    {
        if (! Auth::check()) {
            return new DefaultFeaturitUserContext(
                null,
                null,
                null,
                [
                    'role' => 'Guest',
                ]
            );
        }

        $user = Auth::user();

        $userId = $user->getAuthIdentifier();
        $sessionId = session()->getId();
        $ipAddress = request()->ip();
        
        $role = $user->role;

        return new DefaultFeaturitUserContext(
            $userId,
            $sessionId,
            $ipAddress,
            [
                'role' => $role,
            ]
        );
    }
}
```

Then you must replace your implementation in the config/featurit.php file

```
'featurit_user_context_provider' => My\Namespace\Of\Choice\MyCustomFeaturitUserContextProvider::class,
```

And that should do it, from now on your segmentation rules will use the role attribute.

### Authors

FeaturIT

https://www.featurit.com

featurit.tech@gmail.com