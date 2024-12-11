<?php

namespace AhmedHegazy\FcmHelper;

use Google\Client as GClient;
use Google\Service\FirebaseCloudMessaging;
use Google_Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class FcmHelper
{
    /**
     * return the base url of FCM
     */
    private static function getBaseUrl(): string
    {
        return 'https://fcm.googleapis.com/v1/projects/' . config('fcm-helper.project_name') . '/messages:send';
        return 'https://fcm.googleapis.com/v1/projects/' . config('fcm-helper.project_name') . '/messages:send';
    }

    /**
     * Configure Google client intsance
     */
    private static function initClient(): GClient
    {
        $path = base_path() . '/' . \config('fcm-helper.json_file_path');
        $client = new GClient;
        $path = base_path() . '/' . \config('fcm-helper.json_file_path');
        $client = new GClient;
        try {
            $client->setAuthConfig($path);
            $client->addScope(FirebaseCloudMessaging::FIREBASE_MESSAGING);

            return $client;
        } catch (Google_Exception $e) {
            throw $e;
        }
    }

    private static function generateToken(GClient $client): string
    {
        $client->fetchAccessTokenWithAssertion();
        $accessToken = $client->getAccessToken();

        return $accessToken['access_token'];
    }

    /**
     * Undocumented function
     *
     * @param  string  $userToken
     * @param  array  $bookingDetails  =['id'=>'','date' => '','vendor' => '']
     * @return void
     */
    public static function sendMessage(FCMDTO $dto)
    {

        $client = static::initClient();
        $oauthToken = static::generateToken($client);

        return Http::acceptJson()->withHeaders([
            'Authorization' => 'Bearer ' . $oauthToken,
        ])->post(static::getBaseUrl(), [
            'message' => [
                'token' => $dto->getToken(),
                'notification' => $dto->getNotification(),
                'data' => $dto->getData(),
            ],
        ])->json();
    }

    public static function sendTopic(FCMDTO $dto, string $userType)
    {
        $oauthToken = static::initClient();

        AddNotificationsToUsersJob::dispatch(new \Modules\Notification\DataTransferObjects\NotificationDto(
            $dto->getNotification()['title'],
            $dto->getNotification()['body'],
            'Modules\Notification\Notifications\SendTopicNotification',
        ), $userType)->onQueue('notifications');
        $topic = Str::ulid()->__toString();
        self::registerTokenToTopic($topic, $tokens);
        $response = Http::acceptJson()->withHeaders([
            'Authorization' => 'Bearer ' . $oauthToken,
        ])->post(static::getBaseUrl(), [
            'message' => [
                'topic' => $topic,
                'notification' => $dto->getNotification(),
                'data' => $dto->getData(),
            ],
        ])->json();
        static::removeTokenFromTopic($topic, $tokens);

        return $response;
    }

    public static function registerTokenToTopic(string $topic, array $tokens)
    {
        $oauthToken = static::initClient();

        return Http::withHeaders([
            'access_token_auth' => 'true',
            'authorization' => 'Bearer ' . $oauthToken,
            'Content-Type' => 'application/json',
            'x-goog-api-client' => 'red-type/sa',
            'Host' => 'iid.googleapis.com',
            'User-Agent' => 'GuzzleHttp/7',
            'auth' => 'google_auth',
        ])->post('https://iid.googleapis.com/iid/v1:batchAdd', [
            'to' => '/topics/' . $topic,
            'registration_tokens' => $tokens,
            'to' => '/topics/' . $topic,
            'registration_tokens' => $tokens,
        ])->json();
    }

    public static function removeTokenFromTopic(string $topic, array $tokens)
    {
        $oauthToken = static::initClient();

        return Http::withHeaders([
            'access_token_auth' => 'true',
            'authorization' => 'Bearer ' . $oauthToken,
            'Content-Type' => 'application/json',
            'x-goog-api-client' => 'red-type/sa',
            'Host' => 'iid.googleapis.com',
            'User-Agent' => 'GuzzleHttp/7',
            'auth' => 'google_auth',
        ])->post('https://iid.googleapis.com/iid/v1:batchRemove', [
            'to' => '/topics/' . $topic,
            'registration_tokens' => $tokens,
            'to' => '/topics/' . $topic,
            'registration_tokens' => $tokens,
        ])->json();
    }
}