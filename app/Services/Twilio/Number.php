<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 10/31/2019
 * Time: 12:54 PM
 */

namespace App\Services\Twilio;

use Twilio\Rest\Client;

class Number
{
    /** @var Client */
    public static $client;

    /**
     * @throws \Twilio\Exceptions\ConfigurationException
     */
    public static function setClient()
    {
        self::$client = new Client(config('services.twilio.sid'), config('services.twilio.token'));
    }

    /**
     * @return string
     * @throws \Twilio\Exceptions\ConfigurationException
     * @throws \Twilio\Exceptions\TwilioException
     */
    public static function create()
    {
        self::setClient();

        // List of Numbers
        $numbers = self::$client->availablePhoneNumbers('US')->local->read(['areaCode' => '612']);

        $number = self::$client->incomingPhoneNumbers->create([
            'phoneNumber' => $numbers[0]->phoneNumber,
            'SmsUrl' => route('sms'),
            'VoiceUrl' => route('voice')
        ]);

        return $number->phoneNumber;
    }
}