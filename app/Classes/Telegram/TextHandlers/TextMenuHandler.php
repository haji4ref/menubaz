<?php
/**
 * Created by PhpStorm.
 * User: haji4ref
 * Date: 12/15/19
 * Time: 11:16 PM
 */

namespace App\Classes\Telegram\TextHandlers;

use App\Models\Bot;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;

class TextMenuHandler implements ITextHandler {

    public function handle(Bot $bot)
    {
        $menu_categories = $bot->user->menus()->first()->categories;
        $keyboard = Keyboard::make()
                            ->inline()
                            ->row(
                                Keyboard::inlineButton(['text' => $menu_categories[0]->name, 'callback_data' => $menu_categories[0]->id+1])
                            );

        $response = Telegram::sendMessage([
            'chat_id'      => request()->input('message.chat.id'),
            'text'         => 'Hello World',
            'reply_markup' => $keyboard
        ]);
    }

}
