<?php

namespace Featurit\Client\Laravel\Providers;

use Featurit\Client\Modules\Segmentation\DefaultFeaturitUserContext;
use Featurit\Client\Modules\Segmentation\FeaturitUserContext;
use Featurit\Client\Modules\Segmentation\FeaturitUserContextProvider;
use Illuminate\Support\Facades\Auth;

class LaravelFeaturitContextProvider implements FeaturitUserContextProvider
{
    public function getUserContext(): FeaturitUserContext
    {
        if (! Auth::check()) {
            return new DefaultFeaturitUserContext(
                null,
                null,
                null
            );
        }

        $user = Auth::user();

        $userId = $user->getAuthIdentifier();
        $sessionId = session()->getId();
        $ipAddress = request()->ip();

        return new DefaultFeaturitUserContext(
            $userId,
            $sessionId,
            $ipAddress
        );
    }
}