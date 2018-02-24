<?php namespace Ox\Commands;

use Illuminate\Console\Scheduling\Schedule;
use Ox\Commands\Command;

class SiteDeleteCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'site:delete {site_name : Name of the site}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Delete a site with giving name';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $fs = app('filesystem.symfony');
        $site_name = $this->argument('site_name');
        $site_dir = '/var/www/'.$site_name;
        if (!$fs->exists($site_dir)) {
            $this->failure("Site directory: {$site_dir} not exists");
        }
        $fs->remove($site_dir);
        $this->info("Site: {$site_name} at directory: {$site_dir} deleted successfully");
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
