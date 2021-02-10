<?php

namespace App\Http\Middleware;

use App\UserPermissions;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Closure;

class AuthenticateAlgoliaEmployees
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
        $permissions = new UserPermissions($accessToken);

        if (!$permissions->isAlgoliaEmployee() && !$permissions->isGuest()) {
            \Log::info($permissions->getEmail() . ' is not authorized');
            $request->session()->flush();
            return response()->json(['error' => 'not_authorized'], 403);
        }

        return $next($request);
    }
}
