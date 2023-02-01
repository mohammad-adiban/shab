<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendAdminTelegramNotification extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $template;
    protected $object;
    protected $subject;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($template, $object, $subject)
    {
        $this->template = $template;
        $this->object   = $object;
        $this->subject  = $subject;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        sendTelegramNotification($this->template, $this->object, $this->subject);
        //sendToTelegram($this->template, $this->object, $this->subject);
    }
}
