<?php namespace Ox\Bootstrap;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables as BaseLoadEnvironmentVariables;

class LoadEnvironmentVariables extends BaseLoadEnvironmentVariables
{
    /**
     * If component is installed, bootstrap Environment Variables.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     */
    public function bootstrap(Application $app): void
    {
        if (class_exists(\Dotenv\Dotenv::class)) {
            parent::bootstrap($app);
        }
    }
}
