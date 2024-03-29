<?php namespace Ox;

use ReflectionClass;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Console\Application as Artisan;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Console\Kernel as BaseKernel;

/**
 * This is the Laravel Zero Kernel implementation.
 */
class Kernel extends BaseKernel
{
    /**
     * The application's development commands.
     *
     * @var string[]
     */
    protected $developmentCommands = [
        //Commands\App\Builder::class,
        //Commands\App\Renamer::class,
        //Commands\App\CommandMaker::class,
        //Commands\App\Installer::class,
    ];

    /**
     * The application's bootstrap classes.
     *
     * @var string[]
     */
    protected $bootstrappers = [
        Bootstrap\CoreBindings::class,
        Bootstrap\LoadEnvironmentVariables::class,
        Bootstrap\LoadConfiguration::class,
        \Illuminate\Foundation\Bootstrap\HandleExceptions::class,
        \Illuminate\Foundation\Bootstrap\RegisterFacades::class,
        Bootstrap\RegisterProviders::class,
        \Illuminate\Foundation\Bootstrap\BootProviders::class,
    ];

    /**
     * Kernel constructor.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     * @param \Illuminate\Contracts\Events\Dispatcher $events
     */
    public function __construct(
        \Illuminate\Contracts\Foundation\Application $app,
        \Illuminate\Contracts\Events\Dispatcher $events
    ) {
        if (! defined('ARTISAN_BINARY')) {
            define('ARTISAN_BINARY', basename($_SERVER['SCRIPT_FILENAME']));
        }

        parent::__construct($app, $events);
    }

    /**
     * Gets the application name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->getArtisan()
            ->getName();
    }

    /**
     * Bootstrap the application for artisan commands.
     *
     * @return void
     */
    public function bootstrap()
    {
        parent::bootstrap();

        if ($commandClass = $this->app['config']->get('commands.default')) {
            $this->getArtisan()
                ->setDefaultCommand(
                    $this->app[$commandClass]->getName()
                );
        }
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands(): void
    {
        $config = $this->app['config'];

        /*
         * Loads commands paths.
         */
        $this->load($config->get('commands.paths', $this->app->path('Commands')));

        /**
         * Loads configurated commands.
         */
        $commands = collect($config->get('commands.add', []))
            ->merge($config->get('commands.hidden', []));

        if ($command = $config->get('commands.default')) {
            $commands->push($config->get('commands.default'));
        }

        /*
         * Loads development commands.
         */
        if ($this->app->environment() !== 'production') {
            $commands = $commands->merge($this->developmentCommands);
        }

        $commands = $commands->diff($toRemoveCommands = $config->get('commands.remove', []));

        Artisan::starting(function ($artisan) use ($toRemoveCommands) {
            $reflectionClass = new ReflectionClass(Artisan::class);
            $commands = collect($artisan->all())
                ->filter(
                    function ($command) use ($toRemoveCommands) {
                        return ! in_array(get_class($command), $toRemoveCommands);
                    }
                )
                ->toArray();

            $property = $reflectionClass->getParentClass()
                ->getProperty('commands');

            $property->setAccessible(true);
            $property->setValue($artisan, $commands);
            $property->setAccessible(false);
        });

        /*
         * Registers a bootstrap callback on the artisan console application
         * in order to call the schedule method on each Laravel Zero
         * command class.
         */
        Artisan::starting(function ($artisan) use ($commands) {
            $artisan->resolveCommands($commands->toArray());
        });

        Artisan::starting(function ($artisan) use ($config) {
            collect($artisan->all())->each(function ($command) use ($config) {
                if (in_array(get_class($command), $config->get('commands.hidden', []))) {
                    $command->setHidden(true);
                }

                if ($command instanceof Commands\Command) {
                    $this->app->call([$command, 'schedule']);
                }}
            );
        });
    }
}
