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

        if (!$accessToken || $accessToken->hasExpired()) {
            $provider = \App::make('oauth_provider');
            $authorizationUrl = $provider->getAuthorizationUrl();

            if ($request->isJson()) {
                return JsonResponse::create(['redirect_url' => $authorizationUrl]);
            }

            return redirect($authorizationUrl);
        }

        return $next($request);
    }
}
