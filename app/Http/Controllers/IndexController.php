<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Gallery;
use App\Models\News;
use App\Models\Service;
use App\Models\Stylist;
use App\Models\SystemInformation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Pusher\Pusher;

class IndexController extends Controller
{
    public function index()
    {
        $team = Stylist::orderBy('name')->get();
        $service = Service::orderBy('name')->get();
        $gallery = Gallery::orderBy('created_at', 'desc')->get();
        $news = News::orderBy('news_date', 'desc')->limit(6)->get();
        $system_info = SystemInformation::first();

        $slider_images = [];
        if (!empty($system_info->about_slider_path_1)) {
            $slider_images[] = $system_info->about_slider_path_1;
        }

        if (!empty($system_info->about_slider_path_2)) {
            $slider_images[] = $system_info->about_slider_path_2;
        }

        if (!empty($system_info->about_slider_path_3)) {
            $slider_images[] = $system_info->about_slider_path_3;
        }

        $color_services = $service->where('type', 'cat-color')->pluck('name', 'name')->toArray();
        $basic_services = $service->where('type', 'cat-basics')->pluck('name', 'name')->toArray();
        $serviceList['Color'] = $color_services;
        $serviceList['Basic'] = $basic_services;
        $tels = explode(',', $system_info->contact_number);
        return view('welcome',
            compact('team', 'gallery', 'system_info', 'service', 'news', 'slider_images', 'tels', 'serviceList'));
    }

    public function news($date, $slug)
    {
        $news = News::where('slug', $slug)->firstOrFail();
        return view('news', compact('news'));
    }

    public function processing(Request $request)
    {
        $inputs = $request->validate([
            'type' => 'required|in:contact,booking',
            'name' => 'required|max:191',
            'email' => 'required_if:type,contact|email',
            'message_c' => 'required_if:type,contact',
            'phone' => 'required_if:type,booking',
            'stylist' => 'required_if:type,booking|exists:stylists,id',
            'service' => 'required_if:type,booking|array',
            'datetime' => 'required_if:type,booking|date',
        ]);

        if ($inputs['type'] == 'contact') {
            $system_info = SystemInformation::first();
            Mail::send('emails.contact_us', $inputs, function ($message) use ($system_info) {
                $message->to(empty($system_info->email) ? 'sksiang5335@gmail.com' : $system_info->email,
                    env('APP_NAME') . ' Team')
                    ->subject(env('APP_NAME') . ' :: User Feedback');
            });
        } else {
            $datetime = Carbon::parse($inputs['datetime']);
            $service = implode(', ', $inputs['service']);
            $check_double_booking = Booking::where('name', $inputs['name'])
                ->where('status', 'Pending')
                ->where('tel', $inputs['phone'])
                ->where('booking_date', $datetime->toDateTimeString())
                ->where('services', $service)
                ->where('stylist_id', $inputs['stylist'])
                ->first();

            if (empty($check_double_booking)) {
                $booking = new Booking();
                $booking->name = $inputs['name'];
                $booking->tel = $inputs['phone'];
                $booking->booking_date = $datetime->toDateTimeString();
                $booking->services = $service;
                $booking->stylist_id = $inputs['stylist'];
                $booking->save();

                if(!empty(env('PUSHER_APP_KEY'))) {
                    $options = ['cluster' => env('PUSHER_APP_CLUSTER')];
                    $pusher = new Pusher(env('PUSHER_APP_KEY'), env('PUSHER_APP_SECRET'), env('PUSHER_APP_ID'), $options);
                    $data['message'] = 'New booking from ' . $inputs['name'];
                    $pusher->trigger('booking', 'new', $data);
                }
            }
        }
    }
}
