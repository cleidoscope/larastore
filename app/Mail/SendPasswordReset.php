<?php

namespace App\Mail;

use App\PasswordReset;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendPasswordReset extends Mailable
{
    use Queueable, SerializesModels;

    
    public $passwordReset;
    public $actionUrl;
    public $actionText = "Reset Password";

    public function __construct(PasswordReset $passwordReset)
    {
        $this->passwordReset = $passwordReset;
        $this->actionUrl = url('/recover/reset/').'/'.$passwordReset->token;
    }

    public function build()
    {
        return $this->from('support@cloudstore.ph', 'Cloudstore Philippines')
                ->subject('Password Reset')
                ->view('emails.send-password-reset');
    }
}
