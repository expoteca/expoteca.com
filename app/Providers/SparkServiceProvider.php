<?php

namespace App\Providers;

use Laravel\Spark\Spark;
use Laravel\Spark\Providers\AppServiceProvider as ServiceProvider;

class SparkServiceProvider extends ServiceProvider
{
    /**
     * Your application and company details.
     *
     * @var array
     */
    protected $details = [
        'vendor' => 'Your Company',
        'product' => 'Your Product',
        'street' => 'PO Box 111',
        'location' => 'Your Town, NY 12345',
        'phone' => '555-555-5555',
    ];

    /**
     * The address where customer support e-mails should be sent.
     *
     * @var string
     */
    protected $sendSupportEmailsTo = null;

    /**
     * All of the application developer e-mail addresses.
     *
     * @var array
     */
    protected $developers = [
        'esroyo@gmail.com'
    ];

    /**
     * Indicates if the application will expose an API.
     *
     * @var bool
     */
    protected $usesApi = true;

    /**
     * Finish configuring Spark for the application.
     *
     * @return void
     */
    public function booted()
    {
        Spark::useStripe()->noCardUpFront();

        Spark::freePlan()
            ->features([
                '2 Expos',
            ]);

        Spark::freeTeamPlan()
            ->features([
                '2 Expos',
                '2 Organization members'
            ]);

        Spark::plan('Premium', 'expoteca-single-1')
            ->price(39.99)
            ->trialDays(30)
            ->features([
                'Unlimitted Expos'
            ]);

        Spark::teamPlan('Premium Organization', 'expoteca-organization-1')
            ->price(69.99)
            ->trialDays(30)
            ->features([
                'Unlimitted Expos',
                'Unlimitted Organization members'
            ]);
    }

    public function register()
    {

        Spark::referToTeamAs('organization');

    }
}
