<?php

namespace App\Classes\SMS;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class KavenegarProvider implements ISendSMS
{
    /**
     * $client Client
     *
     */
    private $client;

    private $verifyURL = 'https://api.kavenegar.com/v1/{API-KEY}/verify/lookup.json';

    private $apiKey;

    private $verficationTemplate;

    public function __construct()
    {
        $this->client = new Client();

        $this->apiKey = config('sms.api.key');

        $this->verficationTemplate = config('sms.api.verification.template');
    }

    public function sendVerification($receptor, $code)
    {
        $this
            ->client
            ->post(str_replace('{API-KEY}', $this->apiKey, $this->verifyURL),
                [
                    RequestOptions::HEADERS => [
                        'Content-Length' => 0
                    ],
                    'form_params' => [
                        'receptor' => $receptor,
                        'token' => $code, 'template',
                        'template' => $this->verficationTemplate
                    ]
                ]
            );
    }
}
