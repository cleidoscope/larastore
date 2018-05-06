<?php

namespace App\Mail;

use App\Newsletter;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNewsletter extends Mailable
{
    use Queueable, SerializesModels;

    
    public $newsletter;

    public function __construct(Newsletter $newsletter)
    {
        $this->newsletter = $newsletter;
    }

    public function build()
    {
        $store_name = $this->newsletter->store->name;
        $subject = $this->newsletter->subject;
        
        return $this->from('support@cloudstore.ph', $store_name)
                ->subject($subject)
                ->view('emails.send-newsletter');
    }
}
