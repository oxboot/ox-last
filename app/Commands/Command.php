<?php namespace Ox\Commands;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Console\Command as BaseCommand;

abstract class Command extends BaseCommand
{
    /**
     * Holds an instance of the app, if any.
     *
     * @var \Illuminate\Contracts\Foundation\Application|null
     */
    protected $app;

    /**
     * Execute the console command.
     *
     * @return void
     */
    abstract public function handle(): void;

    /**
     * Define the command's schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     *
     * @return void
     */
    public function schedule(Schedule $schedule): void
    {
    }

    public function setLaravel($laravel)
    {
        parent::setLaravel($this->app = $laravel);
    }
}
