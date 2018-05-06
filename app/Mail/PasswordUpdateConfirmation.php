<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PasswordUpdateConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $actionUrl = "http://www.cloudstore.ph/login";
    public $actionText = "Login";
    

    public function build()
    {
        return $this->from('support@cloudstore.ph', 'Cloudstore Philippines')
                ->subject('Password Update Confirmation')
                ->view('emails.password-update-confirmation');
    }
}
