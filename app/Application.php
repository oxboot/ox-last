<?php namespace Ox;

use Illuminate\Events\EventServiceProvider;
use Ox\Exceptions\ConsoleException;
use Illuminate\Foundation\Application as BaseApplication;
use Symfony\Component\Console\Exception\CommandNotFoundException;

class Application extends BaseApplication
{
    protected function registerBaseServiceProviders()
    {
        $this->register(new EventServiceProvider($this));
    }

    public function version()
    {
        return $this->app['config']->get('app.version');
    }

    public function runningInConsole()
    {
        return true;
    }

    public function isDownForMaintenance()
    {
        return false;
    }

    public function configurationIsCached()
    {
        return false;
    }

    /**
     * Throw an Console Exception with the given data unless the given condition is true.
     *
     * @param  int $code
     * @param  string $message
     * @param  array $headers
     * @return void
     *
     * @throws \Symfony\Component\Console\Exception\CommandNotFoundException
     * @throws Exceptions\ConsoleException
     */
    public function abort($code, $message = '', array $headers = [])
    {
        if ($code == 404) {
            throw new CommandNotFoundException($message);
        }

        throw new ConsoleException($code, $message, $headers);
    }
}
