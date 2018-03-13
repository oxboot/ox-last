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
        $filesystem = app('filesystem.symfony');
        $site_name = $this->argument('site_name');
        $site_dir = '/var/www/'.$site_name;
        if ($filesystem->exists($site_dir)) {
            $this->failure("Site directory: {$site_dir} already exists");
        }
        $filesystem->mkdir($site_dir);
        $filesystem->dumpFile(
            '/etc/nginx/sites-available/'.$site_name,
            app('template.mustache')->render('nginx/site', ['site_name' => $this->argument('site_name')])
        );
        $filesystem->symlink(
            '/etc/nginx/sites-available/'.$site_name,
            '/etc/nginx/sites-enabled/'.$site_name
        );
        $filesystem->chown($site_dir, 'www-data', 'www-data');
        $utils->exec('service nginx restart');
        $this->info("Site: {$site_name} at directory: {$site_dir} created successfully");
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
