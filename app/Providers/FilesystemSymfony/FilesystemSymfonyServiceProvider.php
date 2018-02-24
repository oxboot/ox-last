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
        $this->app->singleton('filesystem.symfony', function ($app) {
            return new FilesystemSymfony();
        });
    }
}
