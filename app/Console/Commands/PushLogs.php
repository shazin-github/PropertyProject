<?php

namespace App\Console\Commands;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Console\Command;
use App\Jobs\Logs;
class PushLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logs:push';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Push Client Request Logs to Queue';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    protected $logs;
    public function __construct(Logs $logs)
    {
        parent::__construct();
        $this->logs = $logs;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $job = (new PriceCalculation($message))->onQueue($queue_type);
            $this->dispatch($job);
    }
}
