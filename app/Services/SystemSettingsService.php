<?php

namespace App\Services;

use Jackiedo\DotenvEditor\DotenvEditor;

/**
 * Class SystemSettingsService
 * @package App\Services
 */
class SystemSettingsService
{
    /**
     * @var DotenvEditor
     */
    protected $editor;

    /**
     * SystemSettingsService constructor.
     * @param DotenvEditor $editor
     */
    public function __construct(DotenvEditor $editor)
    {
        $this->editor = $editor;
    }

    /**
     * @param array $data
     * @return array
     */
    public function getKeys(array $data = [])
    {
        return $this->editor->getKeys($data);
    }

    /**
     * @return array
     */
    public function getMailerSettings()
    {
        return $this->getKeys([
            'MAIL_MAILER', 'MAIL_HOST', 'MAIL_PORT', 'MAIL_USERNAME', 'MAIL_PASSWORD',
            'MAIL_ENCRYPTION', 'MAIL_FROM_ADDRESS', 'MAIL_FROM_NAME'
        ]);
    }

    /**
     * @return array
     */
    public function getSystemSettings()
    {
        return $this->getKeys([
            'APP_NAME', 'APP_ENV', 'APP_DEBUG', 'APP_URL'
        ]);
    }

    /**
     * @param array $data
     * @return DotenvEditor
     */
    public function setKeys(array $data)
    {
        return $this->editor->setKeys($data);
    }

    /**
     * @return DotenvEditor
     */
    public function save()
    {
        return $this->editor->save();
    }
}
