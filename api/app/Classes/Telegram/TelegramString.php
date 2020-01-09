<?php
/**
 * Created by PhpStorm.
 * User: haji4ref
 * Date: 1/9/20
 * Time: 6:24 PM
 */

namespace App\Classes\Telegram;

class TelegramString {

    private $string = '';

    public function append($s, $nextLineNumbers = 2)
    {
        $this->string .= $s;

        for($i = 0; $i < $nextLineNumbers; $i ++)
            $this->string .= PHP_EOL;

        return $this;
    }

    public function get()
    {
        return $this->string;
    }

    public function getString()
    {
        return $this->string;
    }
}
