<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;


class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'Store View',
            'Store Create',
            'Store Edit',
            'Store Delete',

            'User View',
            'User Create',
            'User Edit',
            'User Delete',

            'Coupon View',
            'Coupon Create',
            'Coupon Edit',
            'Coupon Delete',
            'Coupon Rank',

            'Home Settings',
            'Home Banner',
            'Home Coupon/Deals',

            'Site Info',

            'Subscribed Users',
            'User Messages',

            'User View',
            'User Create',
            'User Edit',
            'User Delete',


            'Role View',
            'Role Create',
            'Role Edit',
            'Role Delete',




        ];


        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
