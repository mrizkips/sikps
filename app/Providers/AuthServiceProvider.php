<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('view-akademik', function (User $user) {
            return $user->can('view any akademik');
        });

        Gate::define('view-users', function (User $user) {
            return $user->can('view any user');
        });

        Gate::define('view-proposal', function (User $user) {
            return $user->can('view any proposal');
        });

        Gate::define('view-pengajuan', function (User $user) {
            return $user->can('view any pengajuan');
        });

        Gate::define('view-kp-skripsi', function (User $user) {
            return $user->can('view any kp skripsi');
        });
    }
}
