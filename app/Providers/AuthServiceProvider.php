<?php

namespace App\Providers;

use App\Extensions\FirebaseUserProxyProvider;
use App\Models\Auth\User\User;
use App\Policies\Backend\BackendPolicy;
use App\Policies\Models\User\UserPolicy;
use App\Services\Auth\FirebaseGuard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        /**
         * Models Policies
         */
        User::class => UserPolicy::class,
        /**
         * Without models policies
         */
        'backend' => BackendPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Auth::provider('firebase', function ($app, array $config) {
            // Return an instance of Illuminate\Contracts\Auth\UserProvider...
            return new FirebaseUserProxyProvider();
        });

        Auth::extend('firebase', function ($app, $name, array $config) {
            // Return an instance of Illuminate\Contracts\Auth\Guard...

            return new FirebaseGuard(Auth::createUserProvider($config['provider']), $app['request']);
        });
    }
}
