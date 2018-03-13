<?php namespace Ox\Providers\TemplateMustache;

use Illuminate\Support\ServiceProvider;
use Mustache_Engine as TemplateMustache;

class TemplateMustacheServiceProvider extends ServiceProvider
{
    /**
     * Register Symfony Filesystem service.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(TemplateMustache::class, function ($app) {
            return new TemplateMustache(['loader' => new \Mustache_Loader_FilesystemLoader(base_path() . '/templates')]);
        });

        $this->app->alias(TemplateMustache::class, 'template.mustache');
    }
}
