<?php

namespace App\Http\Controllers;

use App\Classes\Telegram\TextHandlers\TextMenuHandler;
use App\Models\Bot;
use Illuminate\Support\Facades\Log;
use ReflectionClass;
use Telegram\Bot\Actions;
use Telegram\Bot\Laravel\Facades\Telegram;

/**
 * @property \Telegram\Bot\Api telegram
 */
class TelegramController extends Controller
{

    private $expectedTexts = [
        'مشاهده منو' => TextMenuHandler::class
    ];

    /**
     * @param $token
     *
     */
    public function webhook($token)
    {
        $bot = Bot::where('token', $token)->first();

        Telegram::setAccessToken($token);
        
        Telegram::commandsHandler(true);

        if (array_key_exists(request()->input('message.text'), $this->expectedTexts)) {
            $handler = (new ReflectionClass($this->expectedTexts[request()->input('message.text')]))->newInstance();

            $handler->handle($bot);
        }

        return;

        switch (\request()->input('message.text')) {
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
                Telegram::sendPhoto([
                    'chat_id' => request()->input('message.chat.id'),
                    'photo'   => env('APP_URL') . $bot->user->menus->first()->categories->first()->items->first()->gallery->publicUrl,
                    'caption' => $bot->user->menus->first()->categories->first()->items->first()->bolded_description
                    //'reply_markup' => $this->makeCategories($bot)
                ]);
                break;
        }
    }

    private function makeCategories($bot)
    {
        $categories = $bot->user->menus->first()->categories->pluck('name')->toArray();

        $reply_markup = Telegram::replyKeyboardMarkup([
            'keyboard'          => [$categories],
            'resize_keyboard'   => false,
            'one_time_keyboard' => true
        ]);

        return $reply_markup;
    }
}
