<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;

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

        return back();
    }

    public function currentUser(Request $request)
    {
        return $request->session()->get('accessToken');
    }

}