<?php

namespace App\Providers;

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
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('show-projects-menu', function ($user, $projectOperators) {
            if($user->id == auth()->user()->hasRole('admin'))
            {
                return true;
            }

            foreach ($projectOperators as $projectOperator) {
                if($user->id == $projectOperator->user_id)
                {
                    return true;
                }
            }
            return false;
        });
    }
}
