<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mews\Captcha\Facades\Captcha;

// use Mews\Captcha\Facades\Captcha;

class CaptchaController extends Controller
{
    //
    public function getCaptcha()
    {
        return Captcha::create(env('CAPTCHA_STYLE', 'default'));
    }
}
