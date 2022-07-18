<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;

class LogInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'loginfo:key';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Log Info Key';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        \Log::info('Cron berjalan : ' . Carbon::now());
        return 0;
    }
}
