<?php namespace Ox\Bootstrap;

use Ox\Providers;
//use LaravelZero\Framework\Components;
use Illuminate\Contracts\Foundation\Application;
//use NunoMaduro\LaravelConsoleTask\LaravelConsoleTaskServiceProvider;
//use NunoMaduro\LaravelConsoleMenu\LaravelConsoleMenuServiceProvider;
//use NunoMaduro\LaravelConsoleSummary\LaravelConsoleSummaryServiceProvider;
//use NunoMaduro\LaravelDesktopNotifier\LaravelDesktopNotifierServiceProvider;
use Illuminate\Foundation\Bootstrap\RegisterProviders as BaseRegisterProviders;

class RegisterProviders extends BaseRegisterProviders
{
    /**
     * Framework core providers.
     *
     * @var string[]
     */
    protected $providers = [
        Providers\Cache\CacheServiceProvider::class,
        Providers\Filesystem\FilesystemServiceProvider::class,
        Providers\FilesystemSymfony\FilesystemSymfonyServiceProvider::class,
        Providers\TemplateMustache\TemplateMustacheServiceProvider::class,
        //Providers\Composer\ComposerServiceProvider::class,
        //LaravelDesktopNotifierServiceProvider::class,
        //LaravelConsoleTaskServiceProvider::class,
        //LaravelConsoleMenuServiceProvider::class,
        //LaravelConsoleSummaryServiceProvider::class,
    ];

    /**
     * Framework optional components.
     *
     * @var string[]
     */
    protected $components = [
        //Components\Log\Provider::class,
        //Components\Database\Provider::class,
    ];

    /**
     * Bootstrap register providers.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     */
    public function bootstrap(Application $app): void
    {
        /*
         * First, we register Laravel Foundation providers.
         */
        parent::bootstrap($app);

        collect($this->providers)
            ->merge(
                collect($this->components)->filter(
                    function ($component) use ($app) {
                        return (new $component($app))->isAvailable();
                    }
                )
            )
            ->each(
                function ($serviceProviderClass) use ($app) {
                    $app->register($serviceProviderClass);
                }
            );
    }
}
