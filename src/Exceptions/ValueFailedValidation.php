<?php

declare(strict_types=1);

namespace Underwork\SystemConfiguration\Exceptions;

use InvalidArgumentException;

final class ValueFailedValidation extends InvalidArgumentException
{
    public static function create(string $attributeName): static
    {
        return new self("Attribute $attributeName failed the validation.");
    }
}
