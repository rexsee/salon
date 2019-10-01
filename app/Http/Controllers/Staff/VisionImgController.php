<?php

namespace App\Http\Controllers\Staff;

use App\Models\VisionImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

class VisionImgController extends Controller
{
    public function index()
    {
        $result = VisionImage::all();
        return view('staff.vision_img.index', compact('result'));
    }

    public function add(Request $request)
    {
        if ($request->method() == 'POST') {
            $inputs = $request->validate([
                'title' => 'max:191|nullable',
                'order' => 'integer',
                'image' => 'required|mimes:jpeg,jpg,png,gif|max:5120'
            ]);

            $image = $request->file('image');
            $file_name = 'G' . time();
            $full_file_name = $file_name . '.' . $image->getClientOriginalExtension();
            $image->move('storage/vision_img', $full_file_name);
            Image::make('storage/vision_img/' . $full_file_name)->fit('1200', '900')->save();
            Image::make('storage/vision_img/' . $full_file_name)->save('storage/vision_img/' . $file_name . '@2x.' . $image->getClientOriginalExtension());
            $inputs['image_path'] = 'storage/vision_img/' . $full_file_name;

            VisionImage::create($inputs);

            flash('Record added')->success();
            return redirect()->route('staff.vision_img');
        } else {
            return view('staff.vision_img.add');
        }

    }

    public function edit($id, Request $request)
    {
        $record = VisionImage::findOrFail($id);
        if ($request->method() == 'POST') {
            $inputs = $request->validate([
                'title' => 'max:191|nullable',
                'order' => 'integer',
                'image' => 'mimes:jpeg,jpg,png,gif|max:5120'
            ]);

            if (!empty($request->image)) {
                if (File::exists($record->image_path)) {
                    File::delete($record->image_path);
                }

                $image = $request->file('image');
                $file_name = 'G' . time();
                $full_file_name = $file_name . '.' . $image->getClientOriginalExtension();
                $image->move('storage/vision_img', $full_file_name);
                Image::make('storage/vision_img/' . $full_file_name)->fit('1200', '900')->save();
                Image::make('storage/vision_img/' . $full_file_name)->save('storage/vision_img/' . $file_name . '@2x.' . $image->getClientOriginalExtension());
                $inputs['image_path'] = 'storage/vision_img/' . $full_file_name;
            }

            $record->update($inputs);

            flash('Record updated')->success();
            return redirect()->route('staff.vision_img');
        } else {
            return view('staff.vision_img.edit', compact('record'));
        }
    }

    public function delete($id)
    {
        $record = VisionImage::findOrFail($id);

        if (File::exists($record->image_path)) {
            File::delete($record->image_path);
        }

        $record->delete();

        flash('Record deleted')->warning()->important();
        return redirect()->back();
    }
}
