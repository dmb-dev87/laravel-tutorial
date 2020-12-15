<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Twilio\Rest\Client;

use App\Models\User;

class callEveryone extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'call:everyone';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calls everyone with a pre-recorded message';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $sid    = config('twilio.account_sid');
        $token  = config('twilio.auth_token');
        $twilio = new Client( $sid, $token );

        $phone_number = config('twilio.phone_number');

        foreach ( User::cursor() as $user ) {
            $call = $twilio->calls
                ->create( $user->phone_number, // to
                        env('TWILIO_PHONE_NUMBER'), // from
                        [ "url" => "http://demo.twilio.com/docs/voice.xml" ]
                );

        }
    }
}
