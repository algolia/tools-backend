<?php

namespace App\Http\Middleware;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Closure;

class AuthenticateBeta
{
    public function handle(Request $request, Closure $next)
    {
        $accessToken = $request->session()->get('accessToken');

        $values = $accessToken->getValues();
        $email = $values['user']['email'];

        $authorizedEmails = [
            'maxime.locqueville@algolia.com',
            'julien.paroche@algolia.com',
            'michael.sokol@algolia.com',
            'sylvain.huprelle@algolia.com',
            'emily.hayman@algolia.com',
            'nicolas.meuzard@algolia.com',
            'eiji.shinohara@algolia.com',
            'marc.helbling@algolia.com',
            'maria.schreiber@algolia.com',
            'sepehr.fakour@algolia.com',
        ];

        if (!in_array($email, $authorizedEmails)) {
            return response()->json(['error' => 'not_authorized'], 403);
        }

        return $next($request);
    }
}
