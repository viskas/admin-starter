<?php

namespace App\Services;

/**
 * Class GoogleTwoStepAuthService
 * @package App\Services
 */
class GoogleTwoStepAuthService
{
    /**
     * @var \Illuminate\Contracts\Foundation\Application|mixed
     */
    protected $google2fa;

    /**
     * GoogleTwoStepAuthService constructor.
     */
    public function __construct()
    {
        $this->google2fa = app('pragmarx.google2fa');
    }

    /**
     * @return mixed
     */
    public function createSecretKey()
    {
        return $this->google2fa->generateSecretKey();
    }

    /**
     * @param $email
     * @param $secretKey
     * @param null $name
     * @return mixed
     */
    public function generateQrCode($email, $secretKey, $name = null)
    {
        if (!$name) {
            $name = config('app.name');
        }

        return $this->google2fa->getQRCodeInline(
            $name,
            $email,
            $secretKey
        );
    }

    /**
     * @return mixed
     */
    public function login()
    {
        return $this->google2fa->login();
    }
}
