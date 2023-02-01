<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddServiceDeskIssue extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $reservation;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($reservation)
    {
        $this->reservation = $reservation;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        addServiceDeskIssue($this->reservation);
    }
}
