<?php namespace Ox\Providers\Cache;

use Illuminate\Cache\CacheServiceProvider as BaseServiceProvider;

class CacheServiceProvider extends BaseServiceProvider
{
    /**
     * Register the Cache Service Provider.
     *
     * @return void
     */
    public function register(): void
    {
        parent::register();

        if ($this->app['config']->get('cache') === null) {
            $this->app['config']->set('cache', $this->getDefaultConfig());
        }
    }

    /**
     * Returns the default application cache config.
     *
     * We keep it simple using the `array` driver.
     *
     * @return array
     */
    protected function getDefaultConfig(): array
    {
        return [
            'default' => 'array',
            'stores' => [
                'array' => [
                    'driver' => 'array',
                ],
            ],
        ];
    }
}
