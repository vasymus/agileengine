<?php

namespace App\Providers;

use App\Policies\TransactionsPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    const USER_ACCOUNT_TRANSACTION_INDEX = "user.account.transaction.index";
    const USER_ACCOUNT_TRANSACTION_SHOW = "user.account.transaction.show";
    const USER_ACCOUNT_TRANSACTION_CREATE = "user.account.transaction.create";

    /**
     * The policy mappings for the application.
     *
     * @var array
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

//        Gate::define(static::USER_ACCOUNT_TRANSACTION_INDEX, [TransactionsPolicy::class, "index"]);
//        Gate::define(static::USER_ACCOUNT_TRANSACTION_SHOW, [TransactionsPolicy::class, "show"]);
//        Gate::define(static::USER_ACCOUNT_TRANSACTION_CREATE, [TransactionsPolicy::class, "create"]);
    }
}
