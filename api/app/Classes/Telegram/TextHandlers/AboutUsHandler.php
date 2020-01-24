<?php
/**
 * Created by PhpStorm.
 * User: haji4ref
 * Date: 1/24/20
 * Time: 1:29 PM
 */

namespace App\Classes\Telegram\TextHandlers;

use App\Classes\Telegram\TelegramString;
use App\Models\Bot;
use App\Traits\TelegramTemplateMethod;
use Telegram\Bot\Laravel\Facades\Telegram;

class AboutUsHandler {

    use TelegramTemplateMethod;

    public function handle(Bot $bot, $values)
    {
        $text = (new TelegramString(0))
            ->append($bot->contactUsMsg->msg)
            ->get();

        Telegram::sendMessage([
            'chat_id'    => $this->findChatId(),
            'text'       => $text,
            'parse_mode' => 'html',
        ]);
    }

    public function log($memberQuery)
    {
        // TODO: Implement log() method.
    }
}
