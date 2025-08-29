<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
  public function boot()
{
    // Gate::define('access-it', function ($user) {
    //     return $user->role === 'it';
    // });
$allowedRoles = [3, 4, 5, 6];  
Gate::define('overview-logs', function ($user) use ($allowedRoles) {
        return in_array($user->role_id, $allowedRoles, true);
    });
Gate::define('access-it', fn($user) => $user->role_id === 3);
Gate::define('access-software', fn($user) => $user->role_id === 4);
Gate::define('access-hardware', fn($user) => $user->role_id === 5);
Gate::define('access-network', fn($user) => $user->role_id === 6);
}
}
