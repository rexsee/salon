<?php

use Illuminate\Database\Seeder;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $experiences = collect(['Senior', 'Junior']);
        $service_types = collect(['Basic', 'Color']);
        $genders = collect(['Male', 'Female']);
        $specialties = collect(['Color Artist', 'Make-Overs', 'Evening Styles', 'Men\'s Styles', 'Extensions']);

        for ($i = 1; $i < 10; $i++) {
            $stylist = new \App\Models\Stylist();
            $stylist->name = $faker->name;
            $stylist->title = $faker->word;
            $stylist->experience = $experiences->random();
            $stylist->specialty = $specialties->random();
            $stylist->availability = 'Monday,Tuesday,Wednesday,Friday,Saturday,Sunday';
            $stylist->avatar_path = 'storage/stylist/1.jpg';
            $stylist->description = $faker->paragraph;
            $stylist->created_at = \Carbon\Carbon::now()->toDateTimeString();
            $stylist->updated_at = \Carbon\Carbon::now()->toDateTimeString();
            $stylist->save();
        }

        for ($i = 1; $i < 10; $i++) {
            $service = new \App\Models\Service();
            $service->name = $faker->word;
            $service->type = $service_types->random();
            $service->price = rand(2,30) * 10;
            $service->minutes_needed = rand(1,18) * 10;
            $service->description = str_limit($faker->paragraph,190,'');
            $service->created_at = \Carbon\Carbon::now()->toDateTimeString();
            $service->updated_at = \Carbon\Carbon::now()->toDateTimeString();
            $service->save();
        }

        for ($i = 1; $i < 30; $i++) {
            $customer = new \App\Models\Customer();
            $customer->name = $faker->name;
            $customer->tel = $faker->phoneNumber;
            $customer->email = $faker->email;
            $customer->gender = $genders->random();
            $customer->dob = $faker->date();
            $customer->address = $faker->address;
            $customer->city = $faker->city;
            $customer->stylist_id = rand(1,9);
            $customer->created_at = \Carbon\Carbon::now()->toDateTimeString();
            $customer->updated_at = \Carbon\Carbon::now()->toDateTimeString();
            $customer->save();
        }

        for ($i = 1; $i < 100; $i++) {
            $activity = new \App\Models\CustomerLog();
            $activity->services_id = rand(1,9);
            $activity->services = $faker->name;
            $activity->stylist_id = rand(1,9);
            $activity->customer_id = rand(1,29);
            $activity->products = $faker->paragraph;
            $activity->total = rand(5,20) * 10;
            $activity->remark = $faker->paragraph;
            $activity->created_at = \Carbon\Carbon::now()->toDateTimeString();
            $activity->updated_at = \Carbon\Carbon::now()->toDateTimeString();
            $activity->save();
        }
    }
}
