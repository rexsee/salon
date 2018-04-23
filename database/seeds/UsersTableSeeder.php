<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::create(
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('password'),
            ]
        );

        \App\Models\SystemInformation::create(
            [
                'address' => 'This is the Address',
                'contact_number' => '12303 12 312',
                'fax_number' => '1232 12322',
                'email' => 'example@gmail.com',
                'head_line' => 'Hello World',
                'slogan' => 'Slogan 123 sd asd as das',
            ]
        );
    }
}
