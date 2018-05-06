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
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Pusher\Pusher;
use Illuminate\Support\Facades\Validator;

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

        $color_services = $service->where('type', 'cat-color')->pluck('name', 'id')->toArray();
        $basic_services = $service->where('type', 'cat-basics')->pluck('name', 'id')->toArray();
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
        $validator = Validator::make($request->all(), [
            'type' => 'required|in:contact,booking',
            'name' => 'required|max:191',
            'email' => 'required_if:type,contact|email',
            'message_c' => 'required_if:type,contact',
            'phone' => 'required_if:type,booking|digits_between:10,12',
            'stylist' => 'required_if:type,booking|exists:stylists,id',
            'service' => 'required_if:type,booking|array',
            'datetime' => 'required_if:type,booking|date',
        ]);

        if ($validator->fails()) {
            return ['err_msg' => 'Validation failed, please make sure you have filled all the correct info.'];
        }

        try {
            if ($request->type == 'contact') {
                $system_info = SystemInformation::first();
                Mail::send('emails.contact_us', $request->only(['name', 'email', 'message_c']),
                    function ($message) use ($system_info) {
                        $message->to(empty($system_info->email) ? 'sksiang5335@gmail.com' : $system_info->email,
                            env('APP_NAME') . ' Team')
                            ->subject(env('APP_NAME') . ' :: User Feedback');
                    });
            } else {
                if (!ends_with($request->datetime, '00') && !ends_with($request->datetime, '30')) {
                    throw new \Exception('Booking time must in hourly or in every 30 minute.');
                }

                $datetime = Carbon::parse($request->datetime);

                $services_string = '';
                $services_id = '';
                $minutes_take = 0;
                $tel = starts_with($request->phone, '60') ? substr($request->phone, 1) : $request->phone;
                foreach ($request->service as $service_id) {
                    $service = Service::findOrFail($service_id);
                    $services_string .= $service->name . ', ';
                    $services_id .= $service->id . ',';
                    $minutes_take += $service->minutes_needed;
                }
                $check_double_booking = Booking::where('name', $request->name)
                    ->where('status', 'Pending')
                    ->where('tel', $tel)
                    ->where('booking_date', $datetime->toDateTimeString())
                    ->where('services_id', substr($services_id, 0, -1))
                    ->where('stylist_id', $request->stylist)
                    ->first();

                if (empty($check_double_booking)) {
                    $check_status = check_stylist_availability($request->stylist, $datetime, $minutes_take, true);
                    if ($check_status['status'] == false) {
                        if (session()->has('suggest_time')) {
                            session()->flash('suggest_time', $check_status['remark'] . ' Please call us if you having trouble during booking.');
                        }
                        else {
                            session()->flash('suggest_time', $check_status['remark']);
                        }

                        return [
                            'url' => route('booking', [
                                'name' => $request->name,
                                'tel' => $request->phone,
                                'id' => urlencode($request->stylist),
                                'dt' => urlencode($request->datetime),
                                's' => urlencode($services_id)
                            ])
                        ];
                    }
                    $booking = new Booking();
                    $booking->name = $request->name;
                    $booking->tel = $tel;
                    $booking->booking_date = Carbon::parse($request->datetime)->toDateTimeString();
                    $booking->services = substr($services_string, 0, -2);
                    $booking->services_id = substr($services_id, 0, -1);
                    $booking->minutes_take = $minutes_take;
                    $booking->stylist_id = $request->stylist;
                    $booking->save();

                    if (!empty(env('PUSHER_APP_KEY'))) {
                        $options = ['cluster' => env('PUSHER_APP_CLUSTER')];
                        $pusher = new Pusher(env('PUSHER_APP_KEY'), env('PUSHER_APP_SECRET'), env('PUSHER_APP_ID'),
                            $options);
                        $data['message'] = 'New booking from ' . $request->name . ' on ' . $datetime->toFormattedDateString();
                        $pusher->trigger('booking', 'new', $data);
                    }
                }
            }
        } catch (\Exception $e) {
            return ['err_msg' => $e->getMessage()];
        }

        return [];
    }

    public function booking()
    {
        $name = Input::get('name');
        $tel = Input::get('tel');
        $stylist_id = urldecode(Input::get('id'));
        $date = urldecode(Input::get('dt'));
        $services_id = urldecode(Input::get('s'));

        $team = Stylist::orderBy('name')->get();
        $service = Service::orderBy('name')->get();
        $color_services = $service->where('type', 'cat-color')->pluck('name', 'id')->toArray();
        $basic_services = $service->where('type', 'cat-basics')->pluck('name', 'id')->toArray();
        $serviceList['Color'] = $color_services;
        $serviceList['Basic'] = $basic_services;

        if (session()->has('suggest_time')) {
            session()->flash('suggest_time', session('suggest_time'));
            $suggest_time = session('suggest_time');
        }

        return view('booking',
            compact('team', 'serviceList', 'name', 'tel', 'stylist_id', 'date', 'services_id', 'suggest_time'));
    }
}
