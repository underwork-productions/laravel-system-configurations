<?php

declare(strict_types=1);

namespace Underwork\SystemConfiguration\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Underwork\SystemConfiguration\Contracts\SystemConfiguration as SystemConfigurationContract;
use Underwork\SystemConfiguration\Exceptions\ConfigurationDoesNotExists;
use Underwork\SystemConfiguration\Exceptions\MoreThanOneConfiguration;
use Underwork\SystemConfiguration\Exceptions\ValueFailedValidation;

/**
 * @property string $key
 * @property object $data
 * @property ?string $rules
 * @property mixed $value
 * @property string $type
 * @property ?\Illuminate\Support\Carbon $created_at
 * @property ?\Illuminate\Support\Carbon $updated_at
 */
class SystemConfiguration extends Model implements SystemConfigurationContract
{
    use HasUlids;

    protected $guarded = [
        'data',
    ];

    protected $hidden = [
        'data',
    ];

    protected $appends = [
        'value',
    ];

    protected $attributes = [
        'group' => null,
        'data' => '{"value": null}',
        'type' => 'string',
    ];

    protected $casts = [
        'data' => 'object',
    ];

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

    protected function value(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->data->value,
            set: fn (mixed $value) => [
                'data' => json_encode(['value' => match ($this->type) {
                    'boolean' => filter_var($value, FILTER_VALIDATE_BOOLEAN),
                    'float' => floatval($value),
                    'integer' => intval($value),
                    default => var_export($value, true),
                }]),
            ],
        );
    }

    /**
     * Save the model to the database.
     *
     * @return bool
     */
    public function save(array $options = [])
    {
        if ($this->rules && Validator::make(['value' => $this->value], ['value' => $this->rules])->fails()) {
            throw ValueFailedValidation::create($this->key);
        }

        return parent::save($options);
    }

    /**
     * This function allows to skip the validation of the value.
     */
    public function saveUnsafe(array $options = [])
    {
        return parent::save($options);
    }
}
