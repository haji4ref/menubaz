<?php

namespace App\Http\Controllers;

use App\Models\Bot;
use Telegram\Bot\Actions;
use Telegram\Bot\Laravel\Facades\Telegram;

/**
 * @property \Telegram\Bot\Api telegram
 */
class TelegramController extends Controller {

    /**
     * @param $token
     *
     */
    public function webhook($token)
    {

        $bot = Bot::where('token', $token)->first();

        Telegram::setAccessToken($token);

        Telegram::commandsHandler(true);

        switch(\request()->input('message.text')) {
            // ertebat ba ma
            case 'درباره ما':
                Telegram::sendChatAction([
                    'chat_id' => request()->input('message.chat.id'),
                    'action'  => Actions::TYPING,
                ]);

                Telegram::sendMessage([
                    'chat_id' => request()->input('message.chat.id'),
                    'text'    => $bot->contactUsMsg->msg,
                ]);

                break;

            case 'ارسال عکس':

                Telegram::sendMessage([
                    'chat_id' => request()->input('message.chat.id'),
                    'text'    => 'http://kayakweb.ir/storage/destination/12/ymIQi01909.jpg',
                ]);

                break;

            case 'لیست غذاها':
                Telegram::sendMessage([
                    'chat_id' => request()->input('message.chat.id'),
                    'text'    => 'ccc',
                ]);
                break;
        }
    }
}
