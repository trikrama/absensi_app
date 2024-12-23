<?php

namespace App\Helpers;

use GuzzleHttp\Client;

class ReCaptcha
{
    public static function validate($recaptchaResponse)
    {
        $client = new Client();
        $secretKey = env('RECAPTCHA_SECRET_KEY');

        $response = $client->post('https://www.google.com/recaptcha/api/siteverify', [
            'form_params' => [
                'secret' => $secretKey,
                'response' => $recaptchaResponse,
            ]
        ]);

        $result = json_decode($response->getBody(), true);
        return $result['success'] ?? false;
    }
}
