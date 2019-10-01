<?php

namespace App\Http\Controllers\Staff;

use App\Models\News;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

class NewsController extends Controller
{
    public function index()
    {
        $result = News::all();
        return view('staff.news.index', compact('result'));
    }

    public function add(Request $request)
    {
        if ($request->method() == 'POST') {
            $inputs = $request->validate([
                'title' => 'required|max:191',
                'news_date' => 'required|date_format:d/m/Y',
                'type' => 'required',
                'content' => 'required',
                'image' => 'required|mimes:jpeg,jpg,png,gif|max:5120'
            ]);

            $slug = str_slug($inputs['title']);
            $is_slug_exist = News::where('slug',$slug)->first();
            if(!empty($is_slug_exist)) {
                $slug .= rand(1,100);
            }
            $inputs['slug'] = $slug;
            $inputs['news_date'] = Carbon::createFromFormat('d/m/Y',$inputs['news_date'])->toDateString();

            $image = $request->file('image');
            $full_file_name = $slug . '.' . $image->getClientOriginalExtension();
            $image->move('storage/news', $full_file_name);
            Image::make('storage/news/' . $full_file_name)->fit('600', '400')->save();
            $inputs['image_path'] = 'storage/news/' . $full_file_name;

            News::create($inputs);

            flash('Record added')->success();
            return redirect()->route('staff.news');
        } else {
            return view('staff.news.add');
        }

    }

    public function edit($id, Request $request)
    {
        $record = News::findOrFail($id);
        if ($request->method() == 'POST') {
            $inputs = $request->validate([
                'title' => 'required|max:191',
                'news_date' => 'required|date_format:d/m/Y',
                'type' => 'required',
                'content' => 'required',
                'image' => 'required|mimes:jpeg,jpg,png,gif|max:5120'
            ]);

            $slug = str_slug($inputs['title']);
            $is_slug_exist = News::where('slug',$slug)->first();
            if(!empty($is_slug_exist)) {
                $slug .= rand(1,100);
            }
            $inputs['slug'] = $slug;
            $inputs['news_date'] = Carbon::createFromFormat('d/m/Y',$inputs['news_date'])->toDateString();

            if (!empty($request->image)) {
                if (File::exists($record->image_path)) {
                    File::delete($record->image_path);
                }

                $image = $request->file('image');
                $full_file_name = $slug . '.' . $image->getClientOriginalExtension();
                $image->move('storage/news', $full_file_name);
                Image::make('storage/news/' . $full_file_name)->fit('600', '400')->save();
                $inputs['image_path'] = 'storage/news/' . $full_file_name;
            }

            $record->update($inputs);

            flash('Record updated')->success();
            return redirect()->route('staff.news');
        } else {

            return view('staff.news.edit', compact('record'));
        }
    }

    public function delete($id)
    {
        $record = News::findOrFail($id);
        if (File::exists($record->image_path)) {
            File::delete($record->image_path);
        }
        $record->delete();

        flash('Record deleted')->warning()->important();
        return redirect()->back();
    }
}
