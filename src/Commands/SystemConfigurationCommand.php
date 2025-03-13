<?php

namespace Underwork\SystemConfiguration\Commands;

use Illuminate\Console\Command;

class SystemConfigurationCommand extends Command
{
    public $signature = 'laravel-system-configurations';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
