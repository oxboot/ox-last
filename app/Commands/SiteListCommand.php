<?php namespace Ox\Commands;

use Illuminate\Console\Scheduling\Schedule;
use Ox\Commands\Command;

class SiteListCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'site:list';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'List of created sites';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info("List of created sites");
        $sites_dir = '/var/www';
        $sites_dir_subdirs = glob($sites_dir.'/*', GLOB_ONLYDIR);
        var_dump($sites_dir_subdirs);
    }

    /**
     * Define the command's schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
