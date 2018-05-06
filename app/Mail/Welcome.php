<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;

class Welcome extends Mailable
{
    use Queueable, SerializesModels;

    public $actionUrl = "http://www.cloudstore.ph/my-account/store/create";
    public $actionText = "Create my store";
    public $user;
    
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->from('support@cloudstore.ph', 'Cloudstore Philippines')
                ->subject('Welcome to Cloudstore Philippines')
                ->view('emails.welcome');
    }
}
