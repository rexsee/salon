<?php

namespace App\Console\Commands;

use App\Models\Booking;
use App\Models\CustomerActivity;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckBooking extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:booking';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'If the booking past, mart the booking to done and write into customer activity';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $bookings = Booking::whereIn('status',['Confirmed','Postpone'])->where('booking_date','<',Carbon::now()->toDateTimeString())->get();

        foreach ($bookings as $booking){
            $until = Carbon::parse($booking->booking_date->toDateTimeString());
            if($until->addMinutes($booking->minutes_take)->toDateTimeString() < Carbon::now()->toDateTimeString())
            {
                $activity = new CustomerActivity();
                $activity->services_id = $booking->services_id;
                $activity->services = $booking->services;
                $activity->stylist_id = $booking->stylist_id;
                $activity->customer_id = $booking->customer_id;
                $activity->created_at = $booking->booking_date->toDateTimeString();
                $activity->save();

                $booking->update(['status'=>'Done']);
            }
        }

        Log::info('check:booking | ' . count($bookings));
    }
}
