<?php

use Illuminate\Database\Seeder;
use App\Profile;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->truncate();
        DB::table('role_users')->truncate();
        $role = [
            'name' => 'Administrator',
            'slug' => 'administrator',
            'permissions' => [
                'admin' => true,
            ]
        ];
        $adminRole = Sentinel::getRoleRepository()->createModel()->fill($role)->save();
        $subscribersRole = [
            'name' => 'Sponser',
            'slug' => 'sponser',
        ];
        Sentinel::getRoleRepository()->createModel()->fill($subscribersRole)->save();
        $admin = [
            'email'    => 'admin@lightofhopebd.dev',
            'password' => 'admin',
            'gender'   => '1',
            'dob'      => '1994-02-07',
            'slug'     => 'admin',
            'avatar'   => 'public/defaults/avatars/male.png',
            'name'     => 'Admin'
        ];

        $adminUser = Sentinel::registerAndActivate($admin);
        $adminUser->roles()->attach($adminRole);
        $profile = new Profile([
            'user_id' => $adminUser->id,
            'location' => 'Dhaka, Bangladesh',
            'about' => 'Social Service'
        ]);
//        $adminUser->profile()->save($profile);

    }
}
