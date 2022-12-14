<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->id = 1;
        $user->channel = 'backend';
        $user->username = 'system';
        $user->email = 'hungtrinh.un@gmail.com';
        $user->name = 'system';
        $user->password = bcrypt('123456');
        $user->save();
        $user->roles()->attach(Role::where('slug', 'developer')->first());
        $user->permissions()->attach(Role::where('slug', 'developer')->first()
            ->permissions()->select(['permission_id'])
            ->where('role_id', Role::where('slug', 'developer')->first()['id'])->get()->toArray());

        $user = new User();
        $user->id = 2;
        $user->channel = 'frontend';
        $user->username = 'tuannm';
        $user->email = 'hungtrinh.un@gmail.com';
        $user->name = 'Nguyễn Minh Tuấn';
        $user->password = bcrypt('123456');
        $user->save();
        $user->roles()->attach(Role::where('slug', 'subscriber')->first());
    }
}
