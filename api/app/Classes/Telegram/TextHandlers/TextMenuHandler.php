<?php

/**
 * Created by PhpStorm.
 * User: haji4ref
 * Date: 12/15/19
 * Time: 11:16 PM
 */

namespace App\Classes\Telegram\TextHandlers;

use App\Models\Bot;
use App\Traits\TelegramTemplateMethod;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;

class TextMenuHandler {

    use TelegramTemplateMethod;

    private $buttonsPerRow = 4;

    public function handle(Bot $bot)
    {

        $menu_categories = $bot->user->menus()->first()->categories;

        $keyboard = Keyboard::make()->inline();

        for($i = 0; $i <= intval(count($menu_categories) / $this->buttonsPerRow); $i ++) {
            $buttons = $menu_categories
                ->slice($i * $this->buttonsPerRow, $this->buttonsPerRow)
                ->map(function ($value) {
                    return Keyboard::inlineButton(['text' => $value->name, 'callback_data' => 'type=menu_category&values[category_id]=' . $value->id]);
                })->toArray();

            $keyboard->row(...$buttons);
        }

        $response = Telegram::sendMessage([
            'chat_id'      => $this->findChatId(),
            'text'         => ' 📄' . ' منو ' . $bot->user->name . '📄 ',
            'reply_markup' => $keyboard
        ]);
    }

    public function log()
    {
        // TODO: Implement log() method.
    }
}
