<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class WebhookHelper
{
    public static function sendLogMessage($message, $data = [])
    {
        $httpClient = Http::withHeaders([
            'Content-Type' => 'application/json',
        ]);
        $endpoint = env('DISCORD_LOG_WEBHOOK');
        $payload = [
            'content' => $message,
        ];
        if ($data) {
            $payload['embeds'] = [
                [
                    'title' => 'Log data',
                    'description' => json_encode($data),
                    'color' => 5814783,
                ],
            ];
        }
        $httpClient->post($endpoint, $payload);
    }

    public static function sendTransactionMessage($message, $data = [])
    {
        $httpClient = Http::withHeaders([
            'Content-Type' => 'application/json',
        ]);
        $endpoint = env('DISCORD_LOG_WEBHOOK');
        $payload = [
            'content' => $message,
        ];
        if ($data) {
            $payload['embeds'] = [
                [
                    'title' => 'Transaction data',
                    'description' => json_encode($data),
                    'color' => 5814783,
                ],
            ];
        }
        $httpClient->post($endpoint, $payload);
    }
}
