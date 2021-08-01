<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'edit articles']);
        Permission::create(['name' => 'delete articles']);
        Permission::create(['name' => 'publish articles']);
        Permission::create(['name' => 'unpublish articles']);

        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'writer']);
        $role1->givePermissionTo('edit articles');
        $role1->givePermissionTo('delete articles');

        $role2 = Role::create(['name' => 'admin']);
        $role2->givePermissionTo('publish articles');
        $role2->givePermissionTo('unpublish articles');

        $role3 = Role::create(['name' => 'super-admin']);
        // gets all permissions via Gate::before rule; see AuthServiceProvider

        // create demo users
        // $user = \App\Models\User::factory(5000)->create([
        //      'name' => $faker->name(),
        //     'email' => $faker->unique()->safeEmail(),
        //     'email_verified_at' => now(),
        //     'status'=> 'Active',
        //     'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        //     'remember_token' => Str::random(10),
        // ]);
        // $values = array($role1, $role2, $role3);
        // $user->assignRole($values[array_rand($values)]);

        // $user = \App\Models\User::factory(200)->create([
        //      'name' => $faker->name(),
        //     'email' => $faker->unique()->safeEmail(),
        //     'email_verified_at' => now(),
        //     'status'=> 'Active',
        //     'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        //     'remember_token' => Str::random(10),
        // ]);
        // $user->assignRole($role2);

        // $user = \App\Models\User::factory(100)->create([
        //    'name' => $faker->name(),
        //     'email' => $faker->unique()->safeEmail(),
        //     'email_verified_at' => now(),
        //     'status'=> 'Active',
        //     'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        //     'remember_token' => Str::random(10),
        // ]);
        // $user->assignRole($role3);
    }
}
