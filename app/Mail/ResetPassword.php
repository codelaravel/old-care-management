<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $code;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $code)
    {
        $this->email = $user->email;
        $this->code  = $code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address = 'mail@lightofhopebd.org';
        $name = 'Light Of Hope';
        $subject = 'ResetPassword Mail';
        return $this->markdown('emails.resetpassword')
            ->from($address, $name)
            ->cc($address, $name)
            ->bcc($address, $name)
            ->replyTo($address, $name)
            ->subject($subject);
    }
}
