<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];


    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        $gate->define('admin&helper',function ($user)
        {
            $admin_role = 1;
            $helper_role = 2;
            return $user->role_id == $admin_role || $user->role_id == $helper_role;
        });

        $gate->define('admin',function ($user)
        {
            $admin_role = 1;
            return $user->role_id == $admin_role;
        });
    }
}
