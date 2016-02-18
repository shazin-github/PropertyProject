<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use GuzzleHttp\Client;
class Logs extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $log;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    
    public function __construct($log)
    {
        $this->log = $log;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Client $guzzle)
    {
        $elastic_url = 'http://158.69.216.8:9200/logs/log_'.date('Y_m')."/";
        $headers = [
            'Content-Type' => 'application/json',
        ];
        $body = json_encode($this->log);
        $resp = $guzzle->post(
            $elastic_url,
            [
                'headers' => $headers,
                'body' => $body,
                'verify' => FALSE,
                'exceptions' => false
            ]);
        $this->delete();
    }
}
