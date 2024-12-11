<?php

namespace AhmedHegazy\FcmHelper;

use Google\Client as GClient;
use Google\Service\FirebaseCloudMessaging;
use Google_Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class FcmHelper
{
    private static string $oauthToken = '';

    /**
     * return the base url of FCM
     */
    private static function getBaseUrl(): string
    {
        return 'https://fcm.googleapis.com/v1/projects/'.config('fcm-helper.project_name').'/messages:send';
    }

    public static function getHeaders(string $oauthToken): array
    {
        return [
            'access_token_auth' => 'true',
            'authorization' => 'Bearer '.$oauthToken,
            'Content-Type' => 'application/json',
            'x-goog-api-client' => 'red-type/sa',
            'Host' => 'iid.googleapis.com',
            'User-Agent' => 'GuzzleHttp/7',
            'auth' => 'google_auth',
        ];
    }

    /**
     * Configure Google client intsance
     */
    private static function initClient(): GClient
    {
        $path = base_path().'/'.\config('fcm-helper.json_file_path');
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
        if (! empty(self::$oauthToken)) {
            return self::$oauthToken;
        }
        $client->fetchAccessTokenWithAssertion();
        self::$oauthToken = $client->getAccessToken()['access_token'];

        return self::$oauthToken;
    }

    public static function sendMessage(FcmMessage $fcmMessage)
    {

        $client = self::initClient();
        $oauthToken = self::generateToken($client);

        return Http::acceptJson()
            ->withHeaders(self::getHeaders($oauthToken))
            ->post(self::getBaseUrl(), [
                'message' => $fcmMessage->toArray(),
            ])->json();
    }

    public static function sendTopic(FcmMessage $fcmMessage, array $tokens): mixed
    {
        $client = self::initClient();
        $oauthToken = self::generateToken($client);

        $topic = Str::ulid()->__toString();
        self::registerTokenToTopic($topic, $tokens);
        $response = Http::acceptJson()
            ->withHeaders(self::getHeaders($oauthToken))
            ->post(self::getBaseUrl(), [
                'message' => $fcmMessage->toArray(),
            ])
            ->json();
        self::removeTokenFromTopic($topic, $tokens);

        return $response;
    }

    public static function registerTokenToTopic(string $topic, array $tokens)
    {
        $client = self::initClient();
        $oauthToken = self::generateToken($client);

        return Http::withHeaders(self::getHeaders($oauthToken))
            ->post('https://iid.googleapis.com/iid/v1:batchAdd', [
                'to' => '/topics/'.$topic,
                'registration_tokens' => $tokens,
            ])->json();
    }

    public static function removeTokenFromTopic(string $topic, array $tokens)
    {
        $client = self::initClient();
        $oauthToken = self::generateToken($client);

        return Http::withHeaders(self::getHeaders($oauthToken))
            ->post('https://iid.googleapis.com/iid/v1:batchRemove', [
                'to' => '/topics/'.$topic,
                'registration_tokens' => $tokens,
            ])->json();
    }
}
