<?php

namespace App\Mail\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserCreateMail extends Mailable
{
    use Queueable, SerializesModels;

    private $userEmail;

    private $userPassword;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $password)
    {
        $this->userEmail = $email;
        $this->userPassword = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $details = [
            'email' => $this->userEmail,
            'password' => $this->userPassword,
        ];

        return $this->markdown('admin.mail.userCreate')
            ->subject('Доступ в панель администрации')
            ->with('details', $details);
    }
}
