<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Reservation;
use Mail;
use Config;

class SendEmailNotification extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $template;
    protected $object;
    protected $subject;
    protected $recipients;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($template, $object, $subject, $recipients)
    {
        $this->template   = $template;
        $this->object     = $object;
        $this->subject    = $subject;
        $this->recipients = $recipients;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $transport = \Swift_SmtpTransport::newInstance('mail.shab.ir', 25);
        $transport->setUsername('automated@shab.ir');
        $transport->setPassword('jBR96+k9!!!!!');

        $shabmail = \Swift_Mailer::newInstance($transport);

        Mail::setSwiftMailer($shabmail);
        Mail::send($this->template, $this->object, function ($message) {
            $message->subject($this->subject);
            $message->from('automated@shab.ir', 'Shab.ir');
            $message->to($this->recipients);
        });

        /*
        $shabmail_configs = array(
            'driver' => 'smtp',
            'host' => 'mail.shab.ir',
            'port' => '25',
            'username' => 'automated@shab.ir',
            'password' => 'jBR96+k9!!!!!',
        );
        Config::set('mail', $shabmail_configs);

        Mail::send($this->template, $this->object, function ($message) {
            $message->subject($this->subject);
            $message->from('automated@shab.ir', 'Shab.ir');
            $message->to($this->recipients);
        });
        */
    }
}
