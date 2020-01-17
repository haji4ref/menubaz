<?php
/**
 * Created by PhpStorm.
 * User: haji4ref
 * Date: 1/9/20
 * Time: 4:30 PM
 */

namespace App\Traits;

use App\Models\Bot;

trait TelegramTemplateMethod {

    protected $bot = null;

    protected $memberQuery = null;

    protected $values = null;

    public final function method(Bot $bot, $memberQuery, $values = null)
    {
        $this->memberQuery = $memberQuery;

        $this->handle($bot, $values);
        $this->log($memberQuery);
    }

    private function findChat($fields)
    {

        if(array_key_exists('callback_query', $fields)) {
            return $fields['callback_query']['message']['chat'];
        } else {
            return $fields['message']['chat'];
        }
    }

    private function findChatId($fields = null)
    {
        return $this->findChat($fields ?? request()->all())['id'];
    }

    private function findCallBackQueryId($fields = null)
    {
        $tmp = $fields ?? request()->all();

        return $tmp['callback_query']['id'];
    }

    abstract public function handle(Bot $bot, $values);

    abstract public function log($memberQuery);
}
