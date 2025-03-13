<?php

declare(strict_types=1);

namespace Underwork\SystemConfiguration\Contracts;

/**
 * @property int|string $id
 * @property string $name
 * @property string|null $group
 *
 * @mixin \Underwork\SystemConfiguration\Models\SystemConfiguration
 *
 * @phpstan-require-extends \Underwork\SystemConfiguration\Models\SystemConfiguration
 */
interface SystemConfiguration
{
    /**
     * Find a configuration by its key and group
     *
     * @throws \Underwork\SystemConfiguration\Exceptions\ConfigurationDoesNotExists
     * @throws \Underwork\SystemConfiguration\Exceptions\MoreThanOneConfiguration
     */
    public function findByUniqueIdentifier(string $key, ?string $group = null): self;
}
