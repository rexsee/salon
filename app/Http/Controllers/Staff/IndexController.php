<?php

namespace App\Http\Controllers\Staff;

use App\Models\Customer;
use App\Models\SystemInformation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
                'fax_number' => 'max:191|nullable',
                'email' => 'email|nullable',
            ]);

            $record->update($inputs);

            flash('System info updated')->success();
            return redirect()->route('staff.home');
        }
        else {
            $birthday_customer = Customer::where('dob','like','%-' . date('m') . '-%')->count();
            return view('home',compact('record','birthday_customer'));
        }
    }
}
