<?php

/**
 * Created by PhpStorm.
 * User: haji4ref
 * Date: 12/15/19
 * Time: 11:16 PM
 */

namespace App\Classes\Telegram\InlineHandlers;

use App\Http\Controllers\Menu\MenuCategoryController;
use App\Models\Bot;
use App\Models\Menu\MenuCategory;
use App\Traits\TelegramTemplateMethod;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;

class MenuItemsHandler {

    use TelegramTemplateMethod;

    private $buttonsPerRow = 2;

    public function handle(Bot $bot, $values)
    {
        $items = (new MenuCategoryController())->items($values['category_id']);

        $category = MenuCategory::find($values['category_id']);

        $keyboard = Keyboard::make()->inline();

        for($i = 0; $i <= intval(count($items) / $this->buttonsPerRow); $i ++) {

            $buttons = $items
                ->slice($i * $this->buttonsPerRow, $this->buttonsPerRow)
                ->map(function ($value) {
                    return Keyboard::inlineButton([
                        'text'          => $value->name . ' / ' . $value->price . ' تومان ',
                        'callback_data' => 'type=menu_item&values[item_id]=' . $value->id
                    ]);
                })->toArray();

            $keyboard->row(...$buttons);
        }

        $response = Telegram::sendMessage([
            'chat_id'      => $this->findChatId(),
            'text'         => $category->name,
            'reply_markup' => $keyboard
        ]);

        Telegram::answerCallbackQuery([
            'callback_query_id' => $this->findCallBackQueryId()
        ]);

        // return $response;

    }

    public function log($memberQuery)
    {
        // TODO: Implement log() method.
    }
}
