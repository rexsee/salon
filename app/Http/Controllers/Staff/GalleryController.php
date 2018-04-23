<?php

namespace App\Http\Controllers\Staff;

use App\Models\Gallery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

class GalleryController extends Controller
{
    public function index()
    {
        $result = Gallery::all();
        return view('staff.gallery.index', compact('result'));
    }

    public function add(Request $request)
    {
        if ($request->method() == 'POST') {
            $inputs = $request->validate([
                'title' => 'required|max:191',
                'description' => 'max:191|nullable',
                'image' => 'required|mimes:jpeg,jpg,png,gif|max:2048'
            ]);

            $image = $request->file('image');
            $image->move('storage/gallery', $image->getClientOriginalName());
            Image::make('storage/gallery/' . $image->getClientOriginalName())->fit('800', '600')->save();
            $inputs['image_path'] = 'storage/gallery/' . $image->getClientOriginalName();

            Gallery::create($inputs);

            flash('Record added')->success();
            return redirect()->route('staff.gallery');
        } else {
            return view('staff.gallery.add');
        }

    }

    public function edit($id, Request $request)
    {
        $record = Gallery::findOrFail($id);
        if ($request->method() == 'POST') {
            $inputs = $request->validate([
                'title' => 'required|max:191',
                'description' => 'max:191|nullable',
                'image' => 'mimes:jpeg,jpg,png,gif|max:2048'
            ]);

            if (!empty($request->avatar)) {
                if (File::exists($record->image_path)) {
                    File::delete($record->image_path);
                }

                $image = $request->file('image');
                $image->move('storage/gallery', $image->getClientOriginalName());
                Image::make('storage/gallery/' . $image->getClientOriginalName())->fit('800', '600')->save();
                $inputs['image_path'] = 'storage/gallery/' . $image->getClientOriginalName();
            }

            $record->update($inputs);

            flash('Record updated')->success();
            return redirect()->route('staff.gallery');
        } else {
            return view('staff.gallery.edit', compact('record'));
        }
    }

    public function delete($id)
    {
        $record = Gallery::findOrFail($id);

        if (File::exists($record->image_path)) {
            File::delete($record->image_path);
        }

        $record->delete();

        flash('Record deleted')->warning()->important();
        return redirect()->back();
    }
}
