<?php

namespace App\Providers;

use App\Models\User;
use App\Policies\CvPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Cv::class => CvPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('manage-users', function (User $user) {
            return $user->hasAnyRole(['admin']);
        });

        Gate::define('edit-user', function (User $user) {
            return $user->isAdmin();
                        /* ? Response::allow()
                        : Response::denyAsNotFound(); */
        });

        Gate::define('delete-user', function (User $user) {
            return $user->isAdmin();
                        /* ? Response::allow()
                        : Response::denyAsNotFound(); */
        });

        Gate::define('operator-actions', function (User $user) {
            return $user->isOperator(['admin', 'operateur']);
        });

        Gate::define('agent_public-actions', function (User $user) {
            return $user->isAgentPublic(['admin' , 'agent public']);
        });

        Gate::define('supervisor-actions', function (User $user) {
            return $user->isSupervisor(['admin' , 'superviseur']);
        });
    }
}
