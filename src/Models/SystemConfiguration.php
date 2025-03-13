<?php

declare(strict_types=1);

namespace Underwork\SystemConfiguration\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Underwork\SystemConfiguration\Contracts\SystemConfiguration as SystemConfigurationContract;
use Underwork\SystemConfiguration\Exceptions\ConfigurationDoesNotExists;
use Underwork\SystemConfiguration\Exceptions\MoreThanOneConfiguration;

/**
 * @property ?\Illuminate\Support\Carbon $created_at
 * @property ?\Illuminate\Support\Carbon $updated_at
 */
class SystemConfiguration extends Model implements SystemConfigurationContract
{
    use HasUlids;

    protected $guarded = [];

    /**
     * Create a new Eloquent model instance.
     *
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->guarded[] = $this->primaryKey;

        $this->table = config('system-configurations.tables.system_configurations') ?: parent::getTable();
    }

    public function findByUniqueIdentifier(string $key, ?string $group = null): SystemConfigurationContract
    {
        $query = static::query()
            ->where('key', '=', $key)
            ->when(
                empty(trim($group)),
                fn (Builder $query) => $query->whereNull('group'),
                fn (Builder $query) => $query->where('group', '=', trim($group)),
            );

        if ($query->count() === 0) {
            throw ConfigurationDoesNotExists::create($key, $group);
        }

        if ($query->count() > 1) {
            throw MoreThanOneConfiguration::withKey($key);
        }

        return $query->first();
    }
}
