<?php

use Illuminate\Database\Seeder;
use App\Organization;
use \Bouncer as Bouncer;

class OrganizationSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $org = Organization::create([
            'name' => 'Amnesty International',
            'email' => 'contactus@amnesty.org'
        ]);
        $org->users()->attach(1);
        Bouncer::ownedVia(Organization::class, function ($org, $user) {
            return $user->organizations->contains('id', $org->id);
        });
    }
}
