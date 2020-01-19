<?php
/**
 * Created by PhpStorm.
 * User: haji4ref
 * Date: 1/18/20
 * Time: 11:56 PM
 */

namespace App\Classes\Telegram\TextHandlers;

use App\Classes\Telegram\TelegramString;
use App\Models\Bot;
use App\Traits\TelegramTemplateMethod;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;

class UserCommentHandler {

    use TelegramTemplateMethod;

    public function handle(Bot $bot, $values)
    {
        $keyboard = Keyboard::forceReply();

        $user = $bot->user;

        $text = (new TelegramString(0))
            ->append(' خیلی خوشحال میشم نظرتو در مورد ')
            ->append($user->name)
            ->append(' بدونم؟ ')
            ->get();

        Telegram::sendMessage([
            'chat_id'      => $this->findChatId(),
            'text'         => $text,
            'parse_mode'   => 'Markdown',
            'reply_markup' => $keyboard
        ]);
    }

    public function log($memberQuery)
    {
        $memberQuery->update([
            'last_data' => json_encode([
                'handler' => 'submit_comment_user',
            ])
        ]);
    }
}
