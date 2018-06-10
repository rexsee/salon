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
                'title' => 'required|max:191',
                'order' => 'integer',
//                'experience' => 'required|max:191',
//                'specialty' => 'required|array|nullable',
//                'availability' => 'required|array|nullable',
//                'description' => 'required',
                'avatar' => 'required|mimes:jpeg,jpg,png,gif|max:1024'
            ]);

            if (!empty($inputs['availability'])) {
                $inputs['availability'] = implode(',', $inputs['availability']);
            }

            if (!empty($inputs['specialty'])) {
                $inputs['specialty'] = implode(',', $inputs['specialty']);
            }

            $image = $request->file('avatar');
            $file_name = 'AV_' . time();
            $full_file_name = $file_name . '.' . $image->getClientOriginalExtension();
            $image->move('storage/stylist', $full_file_name);
            Image::make('storage/stylist/' . $full_file_name)->fit('500', '700')->save();
            Image::make('storage/stylist/' . $full_file_name)->save('storage/stylist/' . $file_name . '@2x.' . $image->getClientOriginalExtension());
            $inputs['avatar_path'] = 'storage/stylist/' . $full_file_name;

            Stylist::create($inputs);

            flash('Record added')->success();
            return redirect()->route('staff.stylist');
        } else {
            $specialtyList = get_specialty();

            $availabilityList = [
                'monday' => 'Monday',
                'tuesday' => 'Tuesday',
                'wednesday' => 'Wednesday',
                'thursday' => 'Thursday',
                'friday' => 'Friday',
                'saturday' => 'Saturday',
                'sunday' => 'Sunday',
            ];

            return view('staff.stylist.add', compact('specialtyList','availabilityList'));
        }

    }

    public function edit($id, Request $request)
    {
        $record = Stylist::findOrFail($id);
        if ($request->method() == 'POST') {
            $inputs = $request->validate([
                'name' => 'required|max:191',
                'title' => 'required|max:191',
                'order' => 'integer',
//                'experience' => 'required|max:191',
//                'specialty' => 'required|max:191',
//                'availability' => 'required|array|nullable',
//                'description' => 'required',
                'avatar' => 'mimes:jpeg,jpg,png,gif|max:1024'
            ]);

            if (!empty($inputs['availability'])) {
                $inputs['availability'] = implode(',', $inputs['availability']);
            }

            if (!empty($inputs['specialty'])) {
                $inputs['specialty'] = implode(',', $inputs['specialty']);
            }

            if (!empty($request->avatar)) {
                if (File::exists($record->avatar_path)) {
                    File::delete($record->avatar_path);
                }

                $image = $request->file('avatar');
                $file_name = 'AV_' . time();
                $full_file_name = $file_name . '.' . $image->getClientOriginalExtension();
                $image->move('storage/stylist', $full_file_name);
                Image::make('storage/stylist/' . $full_file_name)->fit('500', '700')->save();
                Image::make('storage/stylist/' . $full_file_name)->save('storage/stylist/' . $file_name . '@2x.' . $image->getClientOriginalExtension());
                $inputs['avatar_path'] = 'storage/stylist/' . $full_file_name;
            }

            $record->update($inputs);

            flash('Record updated')->success();
            return redirect()->route('staff.stylist');
        } else {
            $specialtyList = get_specialty();

            $availabilityList = [
                'monday' => 'Monday',
                'tuesday' => 'Tuesday',
                'wednesday' => 'Wednesday',
                'thursday' => 'Thursday',
                'friday' => 'Friday',
                'saturday' => 'Saturday',
                'sunday' => 'Sunday',
            ];

            $availability = explode(',', $record->availability);
            $specialty = explode(',', $record->specialty);
            return view('staff.stylist.edit', compact('specialtyList', 'availabilityList', 'record', 'availability','specialty'));
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
