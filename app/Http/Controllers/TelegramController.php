<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\Actions;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramController extends Controller
{
    public function getMe()
    {
        return Telegram::getMe();
    }

    public function setWebhook()
    {
        $data = Telegram::setWebhook([
            'url' => 'https://a4da66ab.ngrok.io/api/799294587:AAGUgMQgvdOQkKh25JHyQBCkhalM_CJUJQI/webhook'
        ]);

        return $data;
    }

    public function webhook()
    {
        Telegram::commandsHandler(true);

        switch (\request()->input('message.text'))
        {

            case 'درباره ما':
                Telegram::sendChatAction([
                    'chat_id' => request()->input('message.chat.id'),
                    'action' => Actions::TYPING,
                ]);

                Telegram::sendMessage([
                    'chat_id' => request()->input('message.chat.id'),
                    'text' => 'این ربات طراحی شده تا شما در این مکان به آهنگ دلخواه خود گوش کنید❤️',
                ]);

                break;

            case 'ارسال عکس':

                Telegram::sendMessage([
                    'chat_id' => request()->input('message.chat.id'),
                    'text' => 'http://kayakweb.ir/storage/destination/12/ymIQi01909.jpg',
                ]);

                break;

            case 'لیست غذاها':

                Telegram::sendMessage([
                    'chat_id' => request()->input('message.chat.id'),
                    'text' => 'ccc',
                ]);

                break;
        }
    }
}
