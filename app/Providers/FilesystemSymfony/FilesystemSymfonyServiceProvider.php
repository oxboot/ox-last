<?php namespace Ox\Providers\FilesystemSymfony;

use Symfony\Component\Filesystem\Filesystem as FilesystemSymfony;
use Illuminate\Support\ServiceProvider;

class FilesystemSymfonyServiceProvider extends ServiceProvider
{
    /**
     * Register Symfony Filesystem service.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(FilesystemSymfony::class, function ($app) {
            return new FilesystemSymfony();
        });

        $this->app->alias(FilesystemSymfony::class, 'filesystem.symfony');
    }
}
