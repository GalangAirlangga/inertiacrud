<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\Models\User::factory(100)->create();
        $values = array('admin', 'writer', 'super-admin');
        $role = Role::findByName('writer');
        $role->users()->attach($user);
    }
}
