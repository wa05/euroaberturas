<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::updateOrCreate([
            'email' => 'admin@euroaberturas.com'
        ],[
            'password' => bcrypt('secret123'),
            'name' => 'User',
            'last_name' => 'Admin',
            'phone' => '3413638141'
        ]);

        User::updateOrCreate([
            'email' => 'admin@admin.com'
        ],[
            'password' => bcrypt('secret123'),
            'name' => 'User',
            'last_name' => 'Admin',
            'phone' => '3413638141'
        ]);
    }
}
