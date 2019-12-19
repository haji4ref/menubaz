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

    private $buttonsPerRow = 4;

    public function handle(Bot $bot)
    {
        $menu_categories = $bot->user->menus()->first()->categories;

        $keyboard = Keyboard::make()
                            ->inline();
        for($i = 0; $i <= intval(count($menu_categories) / $this->buttonsPerRow); $i ++) {
            $buttons = $menu_categories->slice($i * $this->buttonsPerRow, $this->buttonsPerRow)
                                       ->map(function ($value) {
                                           return Keyboard::inlineButton(['text' => $value->name, 'callback_data' => $value->id]);
                                       })->toArray();
            $keyboard->row(...$buttons);
        }

        $response = Telegram::sendMessage([
            'chat_id'      => request()->input('message.chat.id'),
            'text'         => 'منو رستوران فلان',
            'reply_markup' => $keyboard
        ]);
    }

}
