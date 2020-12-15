<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;

class VoiceController extends Controller
{
    public function __construct() 
    {
        $this->account_sid = env('ACCOUNT_SID');
        $this->auth_token = env('AUTH_TOKEN');

        $this->from = env('TWILIO_PHONE_NUMBER');

        $this->client = new Client($this->account_sid, $this->auth_token);
    }

    public function initiateCall(Request $request)
    {
        $this->validate($request, [
            'phone_number' => 'required|string',
        ]);

        try 
        {
            $phone_number = $this->client->lookups->v1->phoneNumbers($request->phone_number)->fetch();
            if ($phone_number)
            {
                $call = $this->client->account->calls->create(
                    $request->phone_number,
                    $this->from,
                    array(
                        "record" => true,
                        "url" => "http://demo.twilio.com/docs/voice.xml"
                    ));

                if ($call)
                {
                    echo 'Call initiated successfully';
                }
                else 
                {
                    echo 'Call failed';
                }
            }
        }
        catch (Exception $e)
        {
            echo 'Error: ' . $e->getMessage();
        }
        catch (RestException $rest)
        {
            echo 'Error: ' . $rest->getMessage();
        }
    }
}
