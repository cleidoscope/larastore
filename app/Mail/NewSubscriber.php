<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\StoreSubscriber;
use App\User;

class NewSubscriber extends Mailable
{
    use Queueable, SerializesModels;

    public $storeSubscriber;
    
    public function __construct(StoreSubscriber $storeSubscriber)
    {
        $this->storeSubscriber = $storeSubscriber;
    }

    public function build()
    {
        return $this->from('support@cloudstore.ph', 'Cloudstore Philippines')
                ->subject("New subscriber in ".$this->storeSubscriber->store->name)
                ->view('emails.new_subscriber');
    }
}
