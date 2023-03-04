<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Auth\Notifications\ResetPassword;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        // This is will direct user to frontend reset password link
        $app_url = env('APP_URL', 'http://localhost:3000');
        ResetPassword::createUrlUsing(function ($user, string $token) use ($app_url) {
            return $app_url . '/reset-password?token=' . $token . '&email=' . $user->email;
        });
    }
}
