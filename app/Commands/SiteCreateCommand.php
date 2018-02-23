<?php namespace Ox\Commands;

use Illuminate\Console\Scheduling\Schedule;
use Ox\Commands\Command;
use Symfony\Component\Filesystem\Filesystem as File;

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
        $file = new File();
        $site_name = $this->argument('site_name');
        $site_dir = '/var/www/'.$site_name;
        if ($file->exists($site_dir)) {
            $this->failure("Site directory: {$site_dir} already exists");
        }
        $file->mkdir($site_dir);
        $this->info("Site {$site_name} at directory: {$site_dir} created successfully");
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
