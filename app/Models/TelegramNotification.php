<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TelegramNotification extends Model
{
    protected $table = 'telegram_notifications';

    protected $fillable = [
        'chat_token'
    ];
}
