<?php
/**
 * Created by PhpStorm.
 * User: haji4ref
 * Date: 1/10/20
 * Time: 4:03 PM
 */

namespace App\Classes\Telegram\StateBasedHandlers;

use App\Models\Bot;
use App\Traits\TelegramTemplateMethod;
use ReflectionClass;

class StateBasedHandler {

    use TelegramTemplateMethod;

    private $state_based = [
        'submit_comment_item' => SubmitCommentItemHandler::class
    ];

    private $botWithPivot;

    public function handle(Bot $bot, $values)
    {
        $this->botWithPivot = $this->memberQuery->first();

        if($last_data = $this->hasLastData()) {
            $values['last_data'] = $last_data;

            $handler = $this->resolveClass($this->state_based[$last_data['handler']]);

            $handler->method($bot, $this->memberQuery, $values);
        }
    }

    public function log($memberQuery)
    {
        // TODO: Implement log() method.
    }

    private function resolveClass($class)
    {
        return (new ReflectionClass($class))->newInstance();
    }

    private function hasLastData()
    {
        return count(json_decode($this->botWithPivot['pivot']['last_data'], true))
            ? json_decode($this->botWithPivot['pivot']['last_data'], true)
            : null;
    }
}
