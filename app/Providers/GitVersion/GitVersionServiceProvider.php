<?php namespace Ox\Providers\GitVersion;

use Symfony\Component\Process\Process;
use Illuminate\Support\ServiceProvider;

class GitVersionServiceProvider extends ServiceProvider
{
    /**
     * Register Git Tag service.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            'git.version',
            function ($app) {
                ($process = new Process('git describe --tags $(git rev-list --tags --max-count=1)', $app->basePath()))->run();

                return trim($process->getOutput()) ?: 'unreleased';
            }
        );
    }
}
