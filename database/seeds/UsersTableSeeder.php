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
                'image_path' => '',
                'about_slider_path_1' => '',
                'about_slider_path_2' => '',
                'about_slider_path_3' => '',
                'vision_image_path' => '',
                'about_us_desc' => 'this is the about us demo description',
                'vision_desc' => 'this is the vision demo description',
            ]
        );
    }
}
