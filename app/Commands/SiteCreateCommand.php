<?php namespace Ox\Commands;

use Illuminate\Console\Scheduling\Schedule;
use Ox\Commands\Command;

class SiteCreateCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'site:create {site_name : Name of the site}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Create a site with giving name';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info("Site {$this->argument('site_name')} created successfully");
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
