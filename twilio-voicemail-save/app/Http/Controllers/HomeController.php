<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\TwiML\VoiceResponse;
use Twilio\Rest\Client;

class HomeController extends Controller
{
    //
    public function Response()
    {
        print_r("Response");
        $response = new VoiceResponse();
        $response->say('Please leave a message at the beep. Press the star key when finished.');
        $response->record(['maxLength' => 30, 'finishOnKey' => '*', 'action' => 'http://f0dbf644a831.ngrok.io/save', 'method' => 'GET']);
        $response->say('I did not receive a recording');

        echo $response;
    }

    public function Makecall()
    {
        $id = getenv('ACCOUNT_SID');
        $token = getenv('TWILIO_TOKEN');
        $twilio_number = getenv('TWILIO_NUMBER');
        $receiver_number = getenv('RECEIVER_NUMBER');
        $twilio = new Client($id, $token);
        $call = $twilio->calls->create(
            $receiver_number,
            $twilio_number,
            array("url" => "http://f0dbf644a831.ngrok.io/response")
        );
    }

    public function save(Request $request)
    {
        $url = $request->RecordingUrl;
        $img = $request->CallSid . "_" . $request->RecordingSid . ".wav";
        file_put_contents($img, file_get_contents($url));
    }
}
