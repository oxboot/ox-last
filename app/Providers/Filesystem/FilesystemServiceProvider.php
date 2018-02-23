<?php namespace Ox\Providers\Filesystem;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Filesystem\FilesystemServiceProvider as BaseServiceProvider;

class FilesystemServiceProvider extends BaseServiceProvider
{
    /**
     * Register Filesystem service.
     *
     * @return void
     */
    public function register(): void
    {
        parent::register();

        $this->app->alias('filesystem.disk', Filesystem::class);

        $config = $this->app->make('config');

        if ($config->get('filesystems.default') === null) {
            $config->set('filesystems', $this->getDefaultConfig());
        }
    }

    /**
     * Returns the default application filesystems config.
     *
     * We it simple we use the `local` driver.
     *
     * @return array
     */
    protected function getDefaultConfig(): array
    {
        return [
            'default' => 'local',
            'disks' => [
                'local' => [
                    'driver' => 'local',
                    'root' => $this->app->storagePath('app'),
                ],
            ],
        ];
    }
}
