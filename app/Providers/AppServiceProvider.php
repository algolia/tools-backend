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

        var_dump(config('oauth.redirectUri'));
        $this->app->singleton('oauth_provider', function ($app) {
            return new \League\OAuth2\Client\Provider\GenericProvider([
                'clientId'                => config('oauth.clientId'),
                'clientSecret'            => config('oauth.clientSecret'),
                'redirectUri'             => config('oauth.redirectUri'),
                'urlAuthorize'            => config('oauth.urlAuthorize'),
                'urlAccessToken'          => config('oauth.urlAccessToken'),
                'urlResourceOwnerDetails' => config('oauth.urlResourceOwnerDetails')
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
