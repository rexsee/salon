<?php

namespace App\Http\Controllers\Staff;

use App\Models\Customer;
use App\Models\SystemInformation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
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
                $file_name = 'COVER_' . time();
                $full_file_name = $file_name . '.' . $image->getClientOriginalExtension();
                $image->move('storage', $full_file_name);
                Image::make('storage/' . $full_file_name)->fit('1600', '1067')->save();
                Image::make('storage/' . $full_file_name)->save('storage/' . $file_name . '@2x.' . $image->getClientOriginalExtension());
                $inputs['image_path'] = 'storage/' . $full_file_name;
            }

            if (!empty($request->about_image_1)) {
                if (File::exists($record->about_slider_path_1)) {
                    File::delete($record->about_slider_path_1);
                }

                $image = $request->file('about_image_1');
                $file_name = 'AB1_' . time();
                $full_file_name = $file_name . '.' . $image->getClientOriginalExtension();
                $image->move('storage/slider', $full_file_name);
                Image::make('storage/slider/' . $full_file_name)->fit('1200', '900')->save();
                Image::make('storage/slider/' . $full_file_name)->save('storage/slider/' . $file_name . '@2x.' . $image->getClientOriginalExtension());
                $inputs['about_slider_path_1'] = 'storage/slider/' . $full_file_name;
            }

            if (!empty($request->about_image_2)) {
                if (File::exists($record->about_slider_path_2)) {
                    File::delete($record->about_slider_path_2);
                }

                $image = $request->file('about_image_2');
                $file_name = 'AB2_' . time();
                $full_file_name = $file_name . '.' . $image->getClientOriginalExtension();
                $image->move('storage/slider', $full_file_name);
                Image::make('storage/slider/' . $full_file_name)->fit('1200', '900')->save();
                Image::make('storage/slider/' . $full_file_name)->save('storage/slider/' . $file_name . '@2x.' . $image->getClientOriginalExtension());
                $inputs['about_slider_path_2'] = 'storage/slider/' . $full_file_name;
            }

            if (!empty($request->about_image_3)) {
                if (File::exists($record->about_slider_path_3)) {
                    File::delete($record->about_slider_path_3);
                }

                $image = $request->file('about_image_3');
                $file_name = 'AB3_' . time();
                $full_file_name = $file_name . '.' . $image->getClientOriginalExtension();
                $image->move('storage/slider', $full_file_name);
                Image::make('storage/slider/' . $full_file_name)->fit('1200', '900')->save();
                Image::make('storage/slider/' . $full_file_name)->save('storage/slider/' . $file_name . '@2x.' . $image->getClientOriginalExtension());
                $inputs['about_slider_path_3'] = 'storage/slider/' . $full_file_name;
            }

            if (!empty($request->vision_image)) {
                if (File::exists($record->vision_image_path)) {
                    File::delete($record->vision_image_path);
                }

                $image = $request->file('vision_image');
                $file_name = 'V' . time();
                $full_file_name = $file_name . '.' . $image->getClientOriginalExtension();
                $image->move('storage', $full_file_name);
                Image::make('storage/' . $full_file_name)->fit('600', '900')->save();
                Image::make('storage/' . $full_file_name)->save('storage/' . $file_name . '@2x.' . $image->getClientOriginalExtension());
                $inputs['vision_image_path'] = 'storage/' . $full_file_name;
            }

            $record->update($inputs);

            flash('Information updated')->success();
            return redirect()->route('staff.home');
        }
        else {
            if(!empty(env('SMS_USERNAME')) && !empty(env('SMS_BALANCE_URL'))){
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, env('SMS_BALANCE_URL') . '?apiusername='.env('SMS_USERNAME').'&apipassword='.env('SMS_PASSWORD'));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                $sms_balance = curl_exec($ch);
                curl_close($ch);
            }

            $birthday_customer = Customer::where('dob','like','%-' . date('m') . '-%')->count();
            return view('home',compact('record','birthday_customer','sms_balance'));
        }
    }

    public function profile(Request $request)
    {
        if($request->method() == 'POST') {
            $inputs = $request->validate([
                'name' => 'required|max:191',
                'current_password' => 'required|max:191',
                'new_password' => 'required|max:191|confirmed',
            ]);

            if (!Hash::check($inputs['current_password'], auth()->user()->password)) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors('Wrong Current Password');
            }

            auth()->user()->name = $inputs['name'];
            auth()->user()->password = Hash::make($inputs['new_password']);
            auth()->user()->save();

            flash('Profile updated')->success();
            return redirect()->route('staff.home');
        }
        else {
            return view('profile');
        }
    }
}
