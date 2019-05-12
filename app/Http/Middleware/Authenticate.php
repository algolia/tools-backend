<?php

namespace App\Http\Middleware;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Closure;

class Authenticate
{
    public function handle(Request $request, Closure $next)
    {
        $accessToken = $request->session()->get('accessToken');
        $provider = \App::make('oauth_provider');

        if (!$accessToken && $request->input('code')) {
            $accessToken = $provider->getAccessToken('authorization_code', [
                'code' => $_GET['code']
            ]);
        }

        if (!$accessToken || $accessToken->hasExpired()) {
            $authorizationUrl = $provider->getAuthorizationUrl();

            if ($request->isJson()) {
                return JsonResponse::create(['redirect_url' => $authorizationUrl]);
            }

            return redirect($authorizationUrl);
        }

        return $next($request);
    }
}
