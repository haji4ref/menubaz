<?php
/**
 * Created by PhpStorm.
 * User: haji4ref
 * Date: 12/15/19
 * Time: 11:25 PM
 */

namespace App\Classes\Telegram\TextHandlers;

use App\Models\Bot;

interface ITextHandler {

    public function handle(Bot $bot);
}
