<?php

declare(strict_types=1);

namespace Underwork\SystemConfiguration\Exceptions;

use InvalidArgumentException;

final class ConfigurationDoesNotExists extends InvalidArgumentException
{
    public static function create(string $key, ?string $group = null): static
    {
        return new self("There is no configuration with the key `{$key}`".(empty(trim($group)) ? '' : " for the group `{$group}`"));
    }
}
