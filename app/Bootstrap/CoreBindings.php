<?php namespace Ox\Bootstrap;

use Illuminate\Contracts\Foundation\Application;
//use LaravelZero\Framework\Providers\GitVersion\GitVersionServiceProvider;

class CoreBindings
{
    /**
     * Registers service providers that need to be registered
     * on the early stage of the framework.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     */
    public function bootstrap(Application $app): void
    {
        //(new GitVersionServiceProvider($app))->register();
    }
}
