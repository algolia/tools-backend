<?php

namespace App\Http\Middleware;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Closure;

class AuthenticateBeta
{
    function endsWith($string, $endString)
    {
        $len = strlen($endString);
        if ($len == 0) {
            return true;
        }
        return (substr($string, -$len) === $endString);
    }

    public function handle(Request $request, Closure $next)
    {
        $accessToken = $request->session()->get('accessToken');

        $values = $accessToken->getValues();
        $email = $values['user']['email'];

        if ($this->endsWith($email, '@algolia.com')) {
            return response()->json(['error' => 'not_authorized'], 403);
        }

        return $next($request);
    }
}
