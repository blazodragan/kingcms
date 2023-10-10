<?php

namespace App\Traits;

use App\Models\TokenSuiteCRM;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;

trait HasToken
{
    public function getAccessToken()
    {
        // Get the most recent token
        $token = TokenSuiteCRM::latest()->first();
        
        // Check if the token exists and is still valid
        if($token && (time() - strtotime($token->created_at) < $token->expires_in)){
            // If the token is still valid, return it
            return $token->access_token;
        }

        // Request a new token
        $response = $this->requestNewToken($token);

        // Check if the request was successful
        if(!$response->successful()){
            // Handle the error
            throw new \Exception('Unable to retrieve access token');
        }

        // Extract the new access token and refresh token from the response
        $newAccessToken = $response->json()['access_token'];
        $newRefreshToken = $response->json()['refresh_token'] ?? null;
        $newTokenType = $response->json()['token_type'] ?? null;
        $newExpiresIn = $response->json()['expires_in'] ?? null;

        // Store the new token in the database
        TokenSuiteCRM::create([
            'expires_in' => $newExpiresIn,
            'access_token' => $newAccessToken,
            'refresh_token' => $newRefreshToken,
            'token_type' => $newTokenType,
        ]);

        // Return the new access token
        return $newAccessToken;
    }

    private function requestNewToken($token)
    {
        $baseUrl = env('SUITE_API'); // Get the base URL from the .env file
        $endpoint = '/legacy/Api/access_token'; // Your endpoint
        $url = $baseUrl . $endpoint; // Construct the full URL
        // If no token exists, use the client credentials grant type
        return Http::post($url, [
            'grant_type' => 'password',
            'client_id' => env('SUITE_CLIENT_ID'),
            'client_secret' => env('SUITE_CLIENT_SECRET'),
            'username' => env('SUITE_CLIENT_USERNAME'),
            'password' => env('SUITE_CLIENT_PASSWORD'),
            
        ]);
    }
}
