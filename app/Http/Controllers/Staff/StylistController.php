<?php

namespace App\Http\Controllers\Staff;

use App\Models\Stylist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class StylistController extends Controller
{
    public function index()
    {
        $result = Stylist::all();
        return view('staff.stylist.index', compact('result'));
    }

    public function add(Request $request)
    {
        if ($request->method() == 'POST') {
            $inputs = $request->validate([
                'name' => 'required|max:191',
                'experience' => 'required|max:191',
                'specialty' => 'required|max:191',
                'availability' => 'required|array|nullable',
                'description' => 'required',
                'avatar' => 'required|mimes:jpeg,jpg,png,gif|max:1024'
            ]);

            if (!empty($inputs['availability'])) {
                $inputs['availability'] = implode(',', $inputs['availability']);
            }

            $image = $request->file('avatar');
            $image->move('storage/stylist', $image->getClientOriginalName());
            Image::make('storage/stylist/' . $image->getClientOriginalName())->fit('350', '900')->save();
            $inputs['avatar_path'] = 'storage/stylist/' . $image->getClientOriginalName();

            Stylist::create($inputs);

            flash('Record added')->success();
            return redirect()->route('staff.stylist');
        } else {
            $specialtyList = [
                'Color Artist' => 'Color Artist',
                'Make-Overs' => 'Make-Overs',
                'Evening Styles' => 'Evening Styles',
                'Men\'s Styles' => 'Men\'s Styles',
                'Extensions' => 'Extensions',
            ];

            return view('staff.stylist.add', compact('specialtyList'));
        }

    }

    public function edit($id, Request $request)
    {
        $record = Stylist::findOrFail($id);
        if ($request->method() == 'POST') {
            $inputs = $request->validate([
                'name' => 'required|max:191',
                'experience' => 'required|max:191',
                'specialty' => 'required|max:191',
                'availability' => 'required|array|nullable',
                'description' => 'required',
                'avatar' => 'mimes:jpeg,jpg,png,gif|max:1024'
            ]);

            if (!empty($inputs['availability'])) {
                $inputs['availability'] = implode(',', $inputs['availability']);
            }

            if (!empty($request->avatar)) {
                if (File::exists($record->avatar_path)) {
                    File::delete($record->avatar_path);
                }

                $image = $request->file('avatar');
                $image->move('storage/stylist', $image->getClientOriginalName());
                Image::make('storage/stylist/' . $image->getClientOriginalName())->fit('350', '900')->save();
                $inputs['avatar_path'] = 'storage/stylist/' . $image->getClientOriginalName();
            }

            $record->update($inputs);

            flash('Record updated')->success();
            return redirect()->route('staff.stylist');
        } else {
            $specialtyList = [
                'Color Artist' => 'Color Artist',
                'Make-Overs' => 'Make-Overs',
                'Evening Styles' => 'Evening Styles',
                'Men\'s Styles' => 'Men\'s Styles',
                'Extensions' => 'Extensions',
            ];

            $availability = explode(',', $record->availability);
            return view('staff.stylist.edit', compact('specialtyList', 'record', 'availability'));
        }
    }

    public function delete($id)
    {
        $record = Stylist::findOrFail($id);

        if (File::exists($record->avatar_path)) {
            File::delete($record->avatar_path);
        }

        $record->delete();

        flash('Record deleted')->warning()->important();
        return redirect()->back();
    }
}
