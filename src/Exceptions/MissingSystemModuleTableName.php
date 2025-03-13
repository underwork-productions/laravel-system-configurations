<?php

declare(strict_types=1);

namespace Underwork\SystemConfiguration\Exceptions;

use Exception;

final class MissingSystemModuleTableName extends Exception
{
    public static function create()
    {
        return new self('Error: tables.system_configurations on config/system-configurations.php not loaded. Run [php artisan config:clear] and try again.');
    }
}
