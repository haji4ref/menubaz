<?php

namespace App\Http\Controllers\Bot;

use App\Http\Requests\Bot\EditBotRequest;
use App\Http\Requests\Bot\RegisterBotRequest;
use App\Http\Controllers\Controller;
use App\Models\Bot;
use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Laravel\Facades\Telegram;

class BotController extends Controller {

    public function register(RegisterBotRequest $request)
    {
        $botDetail = $this->reload($request->get('token'));

        $bot = auth()->user()->bots()->create([
            'id'         => $botDetail->getId(),
            'name'       => $botDetail->getUsername(),
            'first_name' => $botDetail->getFirstName(),
            'token'      => $request->get('token'),
        ]);

        return $this->index();
    }

    public function index()
    {
        return auth()->user()->bots;
    }

    public function show($id)
    {
        $bot = Bot::find($id);

        return [
            'name'           => $bot->name,
            'contact_us_msg' => $bot->contactUsMsg ? $bot->contactUsMsg->msg : '',
        ];
    }

    public function edit($id, EditBotRequest $request)
    {
        $bot = Bot::find($id);

        $contactMsg = $bot->contactUsMsg;

        if($contactMsg) {
            $contactMsg->update([
                'msg' => $request->get('contact_us_msg')
            ]);
        } else {
            $bot->contactUsMsg()->create([
                'msg' => $request->get('contact_us_msg')
            ]);
        }

        return $this->show($id);
    }

    public function reload($token)
    {
        $this->setWebHook($token);

        return Telegram::setAccessToken($token)->getMe();
    }

    public function setWebHook($token)
    {
        try {
            $telegram = new Api($token);

            $data = $telegram->setWebhook([
                'url' => env('TELEGRAM_BASE_URL') . "/api/$token/webhook"
            ]);

            return $data;
        } catch(TelegramSDKException $e) {

        }
    }
}
