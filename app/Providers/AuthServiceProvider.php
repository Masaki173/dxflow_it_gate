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
// 各部門の権限設定
Gate::define('access-admin', fn($user) => $user->role_id === 1);
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
