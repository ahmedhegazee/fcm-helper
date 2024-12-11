<?php

namespace AhmedHegazy\FcmHelper\Commands;

use Illuminate\Console\Command;

class FcmHelperCommand extends Command
{
    public $signature = 'fcm-helper';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
