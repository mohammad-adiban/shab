<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SetServiceDeskStatus extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $reservation;
    protected $status;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($reservation, $status)
    {
        $this->reservation = $reservation;
        $this->status = $status;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        setServiceDeskStatus($this->reservation, $this->status);
    }
}
