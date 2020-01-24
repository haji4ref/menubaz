<?php
/**
 * Created by PhpStorm.
 * User: haji4ref
 * Date: 1/19/20
 * Time: 12:05 AM
 */

namespace App\Classes\Telegram\StateBasedHandlers;

use App\Http\Controllers\CommentController;
use App\Models\Bot;
use App\Traits\TelegramTemplateMethod;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;

class SubmitCommentUserHandler {

    use TelegramTemplateMethod;

    public function handle(Bot $bot, $values)
    {
        Log::info($bot->user->id);

        (new CommentController())->saveUser($bot->user->id, $values['text']);

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
