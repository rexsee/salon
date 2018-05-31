<?php

namespace App\Http\Controllers\Staff;

use App\Models\Artswork;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

class ArtworkController extends Controller
{
    public function index()
    {
        $result = Artswork::all();
        return view('staff.artwork.index', compact('result'));
    }

    public function add(Request $request)
    {
        if ($request->method() == 'POST') {
            $inputs = $request->validate([
                'title' => 'max:191|nullable',
                'image' => 'required|mimes:jpeg,jpg,png,gif|max:2048'
            ]);

            $image = $request->file('image');
            $file_name = 'G' . time();
            $full_file_name = $file_name . '.' . $image->getClientOriginalExtension();
            $image->move('storage/artwork', $full_file_name);
            Image::make('storage/artwork/' . $full_file_name)->fit('800', '800')->save();
            Image::make('storage/artwork/' . $full_file_name)->save('storage/artwork/' . $file_name . '@2x.' . $image->getClientOriginalExtension());
            $inputs['image_path'] = 'storage/artwork/' . $full_file_name;

            Artswork::create($inputs);

            flash('Record added')->success();
            return redirect()->route('staff.artwork');
        } else {
            return view('staff.artwork.add');
        }

    }

    public function edit($id, Request $request)
    {
        $record = Artswork::findOrFail($id);
        if ($request->method() == 'POST') {
            $inputs = $request->validate([
                'title' => 'max:191|nullable',
                'image' => 'mimes:jpeg,jpg,png,gif|max:2048'
            ]);

            if (!empty($request->image)) {
                if (File::exists($record->image_path)) {
                    File::delete($record->image_path);
                }

                $image = $request->file('image');
                $file_name = 'G' . time();
                $full_file_name = $file_name . '.' . $image->getClientOriginalExtension();
                $image->move('storage/artwork', $full_file_name);
                Image::make('storage/artwork/' . $full_file_name)->fit('800', '800')->save();
                Image::make('storage/artwork/' . $full_file_name)->save('storage/artwork/' . $file_name . '@2x.' . $image->getClientOriginalExtension());
                $inputs['image_path'] = 'storage/artwork/' . $full_file_name;
            }

            $record->update($inputs);

            flash('Record updated')->success();
            return redirect()->route('staff.artwork');
        } else {
            return view('staff.artwork.edit', compact('record'));
        }
    }

    public function delete($id)
    {
        $record = Artswork::findOrFail($id);

        if (File::exists($record->image_path)) {
            File::delete($record->image_path);
        }

        $record->delete();

        flash('Record deleted')->warning()->important();
        return redirect()->back();
    }
}
