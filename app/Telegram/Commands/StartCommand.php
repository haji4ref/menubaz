<?php


namespace App\Telegram\Commands;


use Telegram\Bot\Commands\Command;
use Telegram\Bot\Laravel\Facades\Telegram;

class StartCommand extends Command
{
    protected $name = 'start';
    protected $description  = 'شروع کار با ریات منوباز';
    /**
     * {@inheritdoc}
     */
    public function handle()
    {
        // TODO: Implement handle() method.

        $keyboard = [
            ['ارسال عکس','درباره ما', 'مشاهده منو'],
            ['/help']
        ];

        $reply_markup = Telegram::replyKeyboardMarkup([
            'keyboard' => $keyboard,
            'resize_keyboard' => true,
            'one_time_keyboard' => true
        ]);

        Telegram::sendMessage([
            'chat_id' => request()->input('message.chat.id'),
            'text' => 'سلام '.request()->input('message.chat.first_name').' عزیز',
            'reply_markup' => $reply_markup
        ]);

    }
}
