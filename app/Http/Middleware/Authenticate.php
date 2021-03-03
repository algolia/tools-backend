<?php

namespace App\Http\Middleware;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Closure;
use League\OAuth2\Client\Token\AccessTokenInterface;

class Authenticate
{
    public function handle(Request $request, Closure $next)
    {
        /** @var AccessTokenInterface $accessToken */
        $accessToken = $request->session()->get('accessToken');
        $provider = \App::make('oauth_provider');

        $redirectTo = $request->input('redirect_to');

        if ($redirectTo && strpos($redirectTo, env('VUE_APP_METAPARAMS_FRONTEND_ENDPOINT')) === 0) {
            $request->session()->put('redirect_to', $redirectTo);
        }

        if ($accessToken && $accessToken->hasExpired()) {
            $accessToken = $provider->getAccessToken('refresh_token', [
                'refresh_token' => $accessToken->getRefreshToken()
            ]);
            $request->session()->put('accessToken', $accessToken);
        }

        if (!$accessToken) {
            $authorizationUrl = $provider->getAuthorizationUrl();

            if ($request->isJson()) {
                return JsonResponse::create(['redirect_url' => $authorizationUrl]);
            }

            return redirect($authorizationUrl);
        }

        return $next($request);
    }
}
