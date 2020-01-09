<?php

namespace App\Http\Controllers;

use App\Classes\Telegram\TextHandlers\MenuItemHandler;
use App\Classes\Telegram\TextHandlers\MenuItemsHandler;
use App\Classes\Telegram\TextHandlers\TextMenuHandler;
use App\Models\Bot;
use App\Models\Member;
use ReflectionClass;
use Telegram\Bot\Actions;
use Telegram\Bot\Laravel\Facades\Telegram;

/**
 * @property \Telegram\Bot\Api telegram
 */
class TelegramController extends Controller {

    private $expectedTexts = [
        'مشاهده منو' => TextMenuHandler::class
    ];

    private $inlines = [
        'menu_category' => MenuItemsHandler::class,
        'menu_item'     => MenuItemHandler::class
    ];

    private function hasData($fields)
    {
        return array_key_exists('callback_query', $fields) ? $fields['callback_query']['data'] : null;
    }

    private function hasText($fields)
    {
        return array_key_exists('message', $fields) && array_key_exists('text', $fields['message']) ? $fields['message']['text'] : null;
    }

    private function isInExpected($field)
    {
        return array_key_exists($field, $this->expectedTexts);
    }

    private function resloveClass($class)
    {
        return (new ReflectionClass($class))->newInstance();
    }

    private function resolveMethod($type)
    {
        return explode('@', $this->inlines[$type])[1];
    }

    private function isCommand($fields)
    {
        return
            array_key_exists('message', $fields) &&
            array_key_exists('entities', $fields['message']) &&
            $fields['message']['entities'][0]['type'] === 'bot_command' ?
                $fields['message']['text'] : null;
    }

    /**
     * @param $token
     *
     */
    public function webhook($token)
    {
        $bot = Bot::where('token', $token)->first();

        $fields = request()->all();

        $chatId = $this->findFromId($fields);

        $member = $this->getMember($this->findFrom($fields));

        $memberQuery = $member->bots()->where('bots.id', $bot->id);

        if( ! $memberQuery->exists()) {
            $member->bots()->attach($bot->id);
        }

        $text = '';
        $data = '';
        $command = '';

        Telegram::setAccessToken($token);

        if($command = $this->isCommand($fields)) {
            Telegram::commandsHandler(true);

        } else if($data = $this->hasData($fields)) {
            parse_str($data, $params);

            $object = $this->resloveClass($this->inlines[$params['type']]);

            return $object->method($bot, $memberQuery, $params['values']);

        } else if(($text = $this->hasText($fields)) && $this->isInExpected($text)) {

            $handler = $this->resloveClass($this->expectedTexts[$text]);

            $handler->method($bot, $memberQuery);

        }

        return request()->all();

        switch(\request()->input('message.text')) {
            // ertebat ba ma
            case 'درباره ما':
                Telegram::sendChatAction([
                    'chat_id' => request()->input('message.chat.id'),
                    'action'  => Actions::TYPING
                ]);

                Telegram::sendMessage([
                    'chat_id' => request()->input('message.chat.id'),
                    'text'    => $bot->contactUsMsg->msg
                ]);

                break;

            case 'ارسال عکس':

                Telegram::sendMessage([
                    'chat_id' => request()->input('message.chat.id'),
                    'text'    => 'http://kayakweb.ir/storage/destination/12/ymIQi01909.jpg'
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

    private function findChat($fields)
    {
        if(array_key_exists('callback_query', $fields)) {
            return $fields['callback_query']['message']['chat'];
        } else {
            return $fields['message']['chat'];
        }
    }

    private function findChatId($fields)
    {
        return $this->findChat($fields)['id'];
    }

    private function findFrom($fields)
    {
        if(array_key_exists('callback_query', $fields)) {
            return $fields['callback_query']['from'];
        } else {
            return $fields['message']['from'];
        }
    }

    private function findFromId($fields)
    {
        return $this->findFrom($fields)['id'];
    }

    private function getMember($chat)
    {
        return Member::where('chat_id', $chat['id'])->firstOrCreate([
            'chat_id'    => $chat['id'],
            'first_name' => $chat['first_name'],
            'last_name'  => $chat['last_name'],
            'user_name'  => $chat['username']
        ]);
    }
}
