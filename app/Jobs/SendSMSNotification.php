<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendSMSNotification extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $message;
    protected $to;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($message, $to)
    {
        $this->message = $message;
        $this->to = $to;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
		sendSMS($this->message , $this->to);
    }
}
