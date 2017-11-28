<?php

use Illuminate\Database\Seeder;
use App\Organization;

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
        $org->users()->attach(2);

        $org2 = Organization::create([
            'name' => 'Expoteca',
            'email' => 'expoteca@expoteca.com'
        ]);
        $org2->users()->attach(1);
    }
}
