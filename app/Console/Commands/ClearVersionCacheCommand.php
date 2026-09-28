<?php

namespace App\Console\Commands;

use App\Services\ApplicationVersionService;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:clear-version-cache')]
#[Description('Clear the cached application version value')]
class ClearVersionCacheCommand extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(ApplicationVersionService $applicationVersionService): int
    {
        $applicationVersionService->clearComposerVersionCache();

        $this->info('Cleared cache entry ['.ApplicationVersionService::CACHE_KEY.'].');

        return self::SUCCESS;
    }
}
