<?php

namespace App\Mail\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class UserCreateMail
 * @package App\Mail\Admin
 */
class UserCreateMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * User Email Address
     *
     * @var string
     */
    private $userEmail;

    /**
     * User Password
     *
     * @var string
     */
    private $userPassword;

    /**
     * UserCreateMail constructor.
     * @param $email
     * @param $password
     */
    public function __construct($email, $password)
    {
        $this->userEmail = $email;
        $this->userPassword = $password;
    }

    /**
     * @return UserCreateMail
     */
    public function build()
    {
        $details = [
            'email' => $this->userEmail,
            'password' => $this->userPassword,
        ];

        return $this->markdown('admin.mail.userCreate')
            ->subject(__('Access to the administration panel'))
            ->with('details', $details);
    }
}
