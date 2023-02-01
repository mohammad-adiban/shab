<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendActivationCode extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $code;
    protected $to;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($code, $to)
    {
        $this->code = $code;
        $this->to = $to;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        sendActivationCode($this->code , $this->to);
    }
}
