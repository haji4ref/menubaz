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
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;

class SubmitCommentItemHandler {

    use TelegramTemplateMethod;

    public function handle(Bot $bot, $values)
    {
        (new CommentController())->saveItem($values['last_data']['item_id'], $values['text']);

        $reply_markup = Keyboard::make([
            'resize_keyboard'   => true,
            'one_time_keyboard' => true
        ])->row(
            Keyboard::button(['text' => 'مشاهده منو', 'data' => 'aref']),
            Keyboard::button(['text' => 'درباره ما']),
            Keyboard::button(['text' => 'ارسال نظر'])
        );

        Telegram::sendMessage([
            'chat_id'      => $this->findChatId(),
            'text'         => 'ممنون از ثبت نظرت',
            'parse_mode'   => 'Markdown',
            'reply_markup' => $reply_markup
        ]);
    }

    public function log($memberQuery)
    {
        // TODO: Implement log() method.
    }
}
