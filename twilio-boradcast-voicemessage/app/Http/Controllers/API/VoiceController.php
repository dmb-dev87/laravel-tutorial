<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Twilio\TwiML\VoiceResponse;

class VoiceController extends Controller
{
    public function broadcast()
    {
        $response = new VoiceResponse();
        // $response->play('https://api.twilio.com/cowbell.mp3');
        $response->play('http://demo.twilio.com/docs/classic.mp3');

        echo $response;
    }
}
