<?php

use Illuminate\Database\Seeder;
use App\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class InitUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['root', 'admin', 'manager', 'encoder', 'clerk', 'collector'];

        foreach($roles as $role){
            $model = DB::table('roles')->insert(['name' => $role, 'display_name'=> ucfirst($role)]);
        }
        $users = [
            [
                'name' => 'root',
                'username' => 'root',
                'password' => bcrypt('qwer1234'),
            ],
            [
                'name' => 'Admin',
                'username' => 'admin',
                'password' => bcrypt('qwer1234'),
            ],
            [
                'name' => 'Manager',
                'username' => 'manager',
                'password' => bcrypt('qwer1234'),
            ]
        ];
        foreach($users as $role){
            $model = User::create($role);
        }

    }
}
