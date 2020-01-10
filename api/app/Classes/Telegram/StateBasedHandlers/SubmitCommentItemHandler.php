<?php
/**
 * Created by PhpStorm.
 * User: haji4ref
 * Date: 1/10/20
 * Time: 3:20 PM
 */

namespace App\Classes\Telegram\StateBasedHandlers;

use App\Http\Controllers\CommentController;
use App\Models\Bot;
use App\Traits\TelegramTemplateMethod;
use Telegram\Bot\Laravel\Facades\Telegram;

class SubmitCommentItemHandler {

    use TelegramTemplateMethod;

    public function handle(Bot $bot, $values)
    {
        (new CommentController())->saveItem($values['last_data']['item_id'], $values['text']);

        Telegram::sendMessage([
            'chat_id'    => $this->findChatId(),
            'text'       => 'ممنون از ثبت نظرت',
            'parse_mode' => 'Markdown',
        ]);
    }

    public function log($memberQuery)
    {
        // TODO: Implement log() method.
    }
}
