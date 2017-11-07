<?php

use Illuminate\Database\Seeder;
use App\Organization;
use App\User;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@expoteca.com',
            'password' => bcrypt('1234')
        ]);
        $user->assign('administrator');

        $user = User::create([
            'name' => 'Carles',
            'email' => 'esroyo@gmail.com',
            'password' => bcrypt('1234')
        ]);
    }
}
