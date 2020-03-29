<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\User;
use App\Payment;
use App\Policies\UserPolicy;
use App\Policies\PaymentPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        'App\Models\Team\Post' => 'App\Policies\PostPolicy',
        'App\Models\Team\Tag' => 'App\Policies\TagPolicy',
        'App\Models\Ticketing\Ticket' => 'App\Policies\TicketPolicy',
        'App\Models\Ticketing\Payment' => 'App\Policies\PaymentPolicy',
        'App\Models\Team\Member' => 'App\Policies\MemberPolicy',
        'App\MinistryExam' => 'App\Policies\MinistryExamPolicy',

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
