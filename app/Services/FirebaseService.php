<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Laravel\Firebase\Facades\Firebase;

class FirebaseService
{
    const MESSAGING_TOPIC = "notification";

    public function __construct()
    {
    }

    /**
     * send push firebase messaging
     *
     * @param  string $device_tokens
     * @param  array $notification 
     * @param  array $data
     * @return void
     */
    public static function sendMessaging(string $device_tokens, array $notification, array $data)
    {
        try {
            $messaging = Firebase::messaging();

            $message = CloudMessage::fromArray([
                'token'        => $device_tokens,
                'notification' => $notification,
                'data'         => $data
            ]);
            
            $messaging->send($message);

            return true;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            return false;
        }
    }
    
}