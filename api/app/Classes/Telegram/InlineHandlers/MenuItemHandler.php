<?php

/**
 * Created by PhpStorm.
 * User: haji4ref
 * Date: 12/15/19
 * Time: 11:16 PM
 */

namespace App\Classes\Telegram\InlineHandlers;

use App\Classes\Telegram\TelegramString;
use App\Http\Controllers\Menu\MenuItemController;
use App\Models\Bot;
use App\Traits\TelegramTemplateMethod;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;

class MenuItemHandler {

    use TelegramTemplateMethod;

    public function handle(Bot $bot, $values)
    {
        $item = (new MenuItemController())->show($values['item_id']);

        $string = (new TelegramString())
            ->append('🥙' . $item->name . '🥙')
            ->append('💵' . ' قیمت: ' . $item->price . ' تومان ' . '💵')
            ->append('*' . $item->bolded_description . '*')
            ->append('توضیحات : ' . $item->description)
            ->get();

        $keyboard = $this->makeKeyboard($item);

        Telegram::sendPhoto([
            'chat_id'      => $this->findChatId(),
            'photo'        => InputFile::create(public_path($item->gallery->publicUrl), $item->gallery->name),
            'caption'      => $string,
            'parse_mode'   => 'Markdown',
            'reply_markup' => $keyboard
        ]);

        Telegram::answerCallbackQuery([
            'callback_query_id' => $this->findCallBackQueryId()
        ]);

    }

    public function log($memberQuery)
    {
        // TODO: Implement log() method.
    }

    private function makeKeyboard($item)
    {
        return Keyboard::make()
                       ->inline()
                       ->row(
                           Keyboard::inlineButton([
                               'text'          => '❓' . 'نظرتو در مورد این غذا بگو' . '❓',
                               'callback_data' => 'type=comment_item&values[item_id]=' . $item->id
                           ])
                       );

    }
}
