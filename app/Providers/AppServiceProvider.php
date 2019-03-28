<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }

        $this->app->singleton('oauth_provider', function ($app) {
            return new \League\OAuth2\Client\Provider\GenericProvider([
                'clientId'                => 'fc65e47125f599493be9e43b9dd84efed9c3ef16c78d45958349b901b3e6576d',
                'clientSecret'            => '39a3820b65352daa51d32b0542e990519912b1f28a99387705bfbc2764d8b7c6',
                'redirectUri'             => 'https://metaparams-backend.build/login/callback',
                'urlAuthorize'            => 'https://www.algolia.com/oauth/authorize',
                'urlAccessToken'          => 'https://www.algolia.com/oauth/token',
                'urlResourceOwnerDetails' => 'https://www.algolia.com/oauth/token'
            ]);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
