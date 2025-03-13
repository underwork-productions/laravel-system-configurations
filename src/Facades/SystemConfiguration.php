<?php

namespace Underwork\SystemConfiguration\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Underwork\SystemConfiguration\SystemConfiguration
 */
class SystemConfiguration extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Underwork\SystemConfiguration\SystemConfiguration::class;
    }
}
