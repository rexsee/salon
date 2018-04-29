<?php

namespace App\Http\Controllers\Staff;

use App\Models\Customer;
use App\Models\SystemInformation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

class IndexController extends Controller
{
    public function home(Request $request)
    {
        $record = SystemInformation::first();
        if($request->method() == 'POST') {
            $inputs = $request->validate([
                'address' => 'required|max:191',
                'contact_number' => 'required|max:191',
                'head_line' => 'required|max:191',
                'slogan' => 'required|max:191',
                'about_us_desc' => 'required',
                'vision_desc' => 'required',
                'fax_number' => 'max:191|nullable',
                'email' => 'email|nullable',
                'image' => 'mimes:jpeg,jpg,png,gif|max:2048',
                'vision_image' => 'mimes:jpeg,jpg,png,gif|max:1024',
                'about_image_1' => 'mimes:jpeg,jpg,png,gif|max:2048',
                'about_image_2' => 'mimes:jpeg,jpg,png,gif|max:2048',
                'about_image_3' => 'mimes:jpeg,jpg,png,gif|max:2048',
            ]);

            if (!empty($request->image)) {
                if (File::exists($record->image_path)) {
                    File::delete($record->image_path);
                }

                $image = $request->file('image');
                $image->move('storage', $image->getClientOriginalName());
                Image::make('storage/' . $image->getClientOriginalName())->fit('1600', '1067')->save();
                $inputs['image_path'] = 'storage/' . $image->getClientOriginalName();
            }

            if (!empty($request->about_image_1)) {
                if (File::exists($record->about_slider_path_1)) {
                    File::delete($record->about_slider_path_1);
                }

                $image = $request->file('about_image_1');
                $image->move('storage/slider', $image->getClientOriginalName());
                Image::make('storage/slider/' . $image->getClientOriginalName())->fit('1200', '900')->save();
                $inputs['about_slider_path_1'] = 'storage/slider/' . $image->getClientOriginalName();
            }

            if (!empty($request->about_image_2)) {
                if (File::exists($record->about_slider_path_2)) {
                    File::delete($record->about_slider_path_2);
                }

                $image = $request->file('about_image_2');
                $image->move('storage/slider', $image->getClientOriginalName());
                Image::make('storage/slider/' . $image->getClientOriginalName())->fit('1200', '900')->save();
                $inputs['about_slider_path_2'] = 'storage/slider/' . $image->getClientOriginalName();
            }

            if (!empty($request->about_image_3)) {
                if (File::exists($record->about_slider_path_3)) {
                    File::delete($record->about_slider_path_3);
                }

                $image = $request->file('about_image_3');
                $image->move('storage/slider', $image->getClientOriginalName());
                Image::make('storage/slider/' . $image->getClientOriginalName())->fit('1200', '900')->save();
                $inputs['about_slider_path_3'] = 'storage/slider/' . $image->getClientOriginalName();
            }

            if (!empty($request->vision_image)) {
                if (File::exists($record->vision_image_path)) {
                    File::delete($record->vision_image_path);
                }

                $image = $request->file('vision_image');
                $image->move('storage', $image->getClientOriginalName());
                Image::make('storage/' . $image->getClientOriginalName())->fit('600', '900')->save();
                $inputs['vision_image_path'] = 'storage/' . $image->getClientOriginalName();
            }

            $record->update($inputs);

            flash('Information updated')->success();
            return redirect()->route('staff.home');
        }
        else {
            $birthday_customer = Customer::where('dob','like','%-' . date('m') . '-%')->count();
            return view('home',compact('record','birthday_customer'));
        }
    }
}
