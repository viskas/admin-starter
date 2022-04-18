<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TelegramNotification;
use Illuminate\Http\Request;
use Telegram\Bot\Api;

class TelegramController extends Controller
{
    protected $telegram;

    public function __construct()
    {
        $this->telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
    }

    public function init(Request $request)
    {
        $command = isset($request["message"]["text"]) ? $request["message"]["text"] : '';
        $chat_id = isset($request["message"]["chat"]["id"]) ? $request["message"]["chat"]["id"] : '';

        if ($command) {
            switch ($command) {
                case "/start":
                    $text = "Подтвердите себя кодовым предложением!";
                    return $this->telegram->sendMessage(['chat_id' => $chat_id, 'text' => $text]);
                case "Токен уведомления qwerty":
                    return $this->secretWord($chat_id);
                default:
                    return $this->telegram->sendMessage(['chat_id' => $chat_id, 'text' => 'Не корректные данные.']);
            }
        }
    }

    protected function secretWord($chatId)
    {
        $token = TelegramNotification::where('chat_token', $chatId)->first();

        if ($token) {
            return $this->telegram->sendMessage(['chat_id' => $chatId, 'text' => 'Вы уже себя подтвердили и вам доступны уведомления.']);
        }

        $newToken = new TelegramNotification([
           'chat_token' => $chatId
        ]);

        $newToken->save();

        return $this->telegram->sendMessage(['chat_id' => $chatId, 'text' => 'Все верно! Теперь вам доступны уведомления.']);
    }
}
