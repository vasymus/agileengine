<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class RunAllCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run-all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run all console command for deploying';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Artisan::call("key:generate");
        Artisan::call("migrate");
        Artisan::call("db:seed");
        Artisan::call("l5-swagger:generate");
        return 0;
    }
}
