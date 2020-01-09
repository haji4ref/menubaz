<?php

/**
 * Created by PhpStorm.
 * User: haji4ref
 * Date: 12/15/19
 * Time: 11:16 PM
 */

namespace App\Classes\Telegram\TextHandlers;

use App\Classes\Telegram\TelegramString;
use App\Http\Controllers\Menu\MenuItemController;
use App\Models\Bot;
use App\Traits\TelegramTemplateMethod;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Laravel\Facades\Telegram;

class MenuItemHandler {

    use TelegramTemplateMethod;

    public function handle(Bot $bot, $values)
    {
        $item = (new MenuItemController())->show($values['item_id']);

        $string = (new TelegramString())
            ->append('🥙' . $item->name . '🥙')
            ->append('*' . $item->bolded_description . '*', 1)
            ->get();

        Telegram::sendPhoto([
            'chat_id'    => $this->findChatId(),
            'photo'      => InputFile::create(public_path($item->gallery->publicUrl), $item->gallery->name),
            'caption'    => $string,
            'parse_mode' => 'Markdown'
        ]);

        Telegram::answerCallbackQuery([
            'callback_query_id' => $this->findCallBackQueryId()
        ]);

    }

    public function log($memberQuery)
    {
        // TODO: Implement log() method.
    }
}
