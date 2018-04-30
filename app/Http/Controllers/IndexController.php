<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\News;
use App\Models\Service;
use App\Models\Stylist;
use App\Models\SystemInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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

        $tels = explode(',',$system_info->contact_number);
        return view('welcome', compact('team', 'gallery', 'system_info', 'service', 'news', 'slider_images','tels'));
    }

    public function news($date, $slug)
    {
        $news = News::where('slug', $slug)->firstOrFail();
        return view('news',compact('news'));
    }

    public function contact(Request $request){
        $inputs = $request->validate([
            'name' => 'required|max:191',
            'email' => 'required|email',
            'message_c' => 'required',
        ]);

        $system_info = SystemInformation::first();
        Mail::send('emails.contact_us', $inputs, function ($message) use ($system_info) {
            $message->to(empty($system_info->email) ? 'sksiang5335@gmail.com' : $system_info->email, env('APP_NAME') . ' Team')
                ->subject(env('APP_NAME') . ' :: User Feedback');
        });
    }
}
