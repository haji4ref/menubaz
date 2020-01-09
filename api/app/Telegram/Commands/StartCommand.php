<?php

namespace App\Telegram\Commands;

use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;

class StartCommand extends Command {

    protected $name = 'start';

    protected $description = 'شروع کار با ریات منوباز';

    /**
     * {@inheritdoc}
     */
    public function handle()
    {
        $reply_markup = Keyboard::make([
            'resize_keyboard'   => true,
            'one_time_keyboard' => true
        ])->row(
            Keyboard::button(['text' => 'مشاهده منو', 'data' => 'aref']),
            Keyboard::button(['text' => 'درباره ما']),
            Keyboard::button(['text' => 'ارسال عکس'])
        );

        Telegram::sendMessage([
            'chat_id'      => request()->input('message.chat.id'),
            'text'         => 'سلام ' . request()->input('message.chat.first_name') . ' عزیز',
            'reply_markup' => $reply_markup
        ]);

    }

}
