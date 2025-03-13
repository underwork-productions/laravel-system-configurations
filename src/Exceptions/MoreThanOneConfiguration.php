<?php

declare(strict_types=1);

namespace Underwork\SystemConfiguration\Exceptions;

use InvalidArgumentException;

final class MoreThanOneConfiguration extends InvalidArgumentException
{
    public static function withKey(string $key): static
    {
        return new self("Multiple configurations found with key `{$key}`. Try narrowing down your search with a group.");
    }
}
