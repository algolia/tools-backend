<?php

namespace App\Http\Controllers;

use App\UserPermissions;
use Illuminate\Http\Request;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use Monolog\Logger;

class AuthController
{
    public function algoliaLoginCallback(Request $request)
    {
        /** @var \League\OAuth2\Client\Provider\GenericProvider $provider */
        $provider = \App::make('oauth_provider');

        try {
            $accessToken = $provider->getAccessToken('authorization_code', [
                'code' => $request->query->get('code'),
            ]);

            $request->session()->put('accessToken', $accessToken);
        } catch (IdentityProviderException $e) {
            dd('Error while connecting to Algolia');
        }

        if ($request->isJson()) {
            return $this->currentUser($request);
        }

        $redirectTo = $request->session()->get('redirect_to');

        if ($redirectTo && str_starts_with($redirectTo, env('VUE_APP_METAPARAMS_BACKEND_ENDPOINT'))) {
            return redirect($redirectTo);
        }

        return back();
    }

    private function getIp(Request $request)
    {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? false;

        if (!$ip) {
            if (env('APP_ENV') === 'local') {
                $ip = file_get_contents('https://api.ipify.org');
            } else {
                $ip = $request->ip();
            }
        }

        return $ip;
    }

    public function currentUser(Request $request)
    {
        $token = $request->session()->get('accessToken');
        $jsonToken = $token->jsonSerialize();
        $userPermissions = new UserPermissions($token);

        $ip = $this->getIp($request);

        $signature = env('ENGINE_SIGNATURE');

        if ($userPermissions->isAlgoliaEmployee() && $signature) {
            $jsonToken['signature'] = $ip.$signature;
        }

        $imageProxySigningKey = env('IMAGE_PROXY_SIGNING_KEY');
        $imageProxySigningSalt = env('IMAGE_PROXY_SIGNING_SALT');
        $imageProxyBaseUrl = env('IMAGE_PROXY_BASE_URL');

        if ($imageProxySigningKey && $imageProxySigningSalt && $imageProxyBaseUrl) {
            $jsonToken['imageProxy'] = [
                'signingKey' => $imageProxySigningKey,
                'signingSalt' => $imageProxySigningSalt,
                'baseUrl' => $imageProxyBaseUrl,
            ];
        }

        if ($request->wantsJson()) {
            return $jsonToken;
        } else {
            return "Logged in";
        }
    }

    public function getSignature($appId, Request $request)
    {
        $ip = $this->getIp($request);

        $base = $appId.$ip;
        $encrypt = env('ENGINE_SIGNATURE');
        $toHash = $base.$encrypt;
        $signature = hash('sha256', $toHash);

        return [
            'signature' => $signature
        ];
    }

    public function getAppsCredentials() {
        return [
            'appId' => env('ALGOLIA_APPLICATIONS_APP_ID'),
            'apiKey' => env('ALGOLIA_APPLICATIONS_API_KEY'),
            'indexName' => env('ALGOLIA_APPLICATIONS_INDEX_NAME'),
        ];
    }
}
