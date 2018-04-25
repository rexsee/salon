<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\News;
use App\Models\Service;
use App\Models\Stylist;
use App\Models\SystemInformation;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $team = Stylist::orderBy('name')->get();
        $service = Service::orderBy('name')->get();
        $gallery = Gallery::orderBy('created_at', 'desc')->get();
        $news = News::orderBy('news_date', 'desc')->limit(6)->get();
        $system_info = SystemInformation::first();
        return view('welcome', compact('team', 'gallery', 'system_info', 'service', 'news'));
    }

    public function news($date, $slug)
    {
        $news = News::where('slug',$slug)->firstOrFail();
        dd($news);
    }
}
