<?php namespace Ox\Bootstrap;

use Symfony\Component\Finder\Finder;
use Illuminate\Console\Application as Artisan;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Bootstrap\LoadConfiguration as BaseLoadConfiguration;

class LoadConfiguration extends BaseLoadConfiguration
{
    /**
     * Bootstrap configurations.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     */
    public function bootstrap(Application $app): void
    {
        parent::bootstrap($app);

        $app->detectEnvironment(function () use ($app) {
            return $app['config']->get('app.production', true) ? 'production' : 'development';
        });

        /*
         * When artisan starts, sets the application name
         * and the application version.
         */
        Artisan::starting(
            function ($artisan) use ($app) {
                $artisan->setName($app['config']->get('app.name', 'Oxboot'));
                $artisan->setVersion($app->version());
            }
        );
    }

    /**
     * Get all of the configuration files for the application.
     *
     * @param  \Illuminate\Contracts\Foundation\Application $app
     *
     * @return array
     */
    protected function getConfigurationFiles(Application $app): array
    {
        $files = [];

        $configPath = $app->configPath();

        $configFiles = Finder::create()
            ->files()
            ->name('*.php')
            ->in($configPath);

        foreach ($configFiles as $file) {
            $directory = $this->getNestedDirectory($file, $configPath);
            $files[$directory . basename($file->getPathName(), '.php')] = $file->getPathName();
        }

        ksort($files, SORT_NATURAL);

        return $files;
    }
}
