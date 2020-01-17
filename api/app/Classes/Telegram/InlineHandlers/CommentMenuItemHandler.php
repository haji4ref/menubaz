<?php
/**
 * Created by PhpStorm.
 * User: haji4ref
 * Date: 1/10/20
 * Time: 1:46 PM
 */

namespace App\Classes\Telegram\InlineHandlers;

use App\Classes\Telegram\TelegramString;
use App\Models\Bot;
use App\Models\Menu\MenuItem;
use App\Traits\TelegramTemplateMethod;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;

class CommentMenuItemHandler {

    use TelegramTemplateMethod;

    private $itemId = null;

    public function handle(Bot $bot, $values)
    {
        $this->itemId = $values['item_id'];

        $item = MenuItem::find($this->itemId);

        $keyboard = Keyboard::forceReply();

        $text = (new TelegramString(0))
            ->append(' خب نظرت در مورد ')
            ->append($item->name)
            ->append(' ')
            ->append($item->ownerName())
            ->append(' چیه؟ ')
            ->get();

        Telegram::sendMessage([
            'chat_id'      => $this->findChatId(),
            'text'         => $text,
            'parse_mode'   => 'Markdown',
            'reply_markup' => $keyboard
        ]);

    }

    public function log($memberQuery)
    {
        $memberQuery->update([
            'last_data' => json_encode([
                'handler' => 'submit_comment_item',
                'item_id' => $this->itemId,
            ])
        ]);
    }
}
