<?php

namespace App\Http\Controllers\Staff;

use App\Models\Customer;
use App\Models\CustomerActivity;
use App\Models\Stylist;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class CustomerController extends Controller
{
    public function index()
    {
        if(Input::get('type') == 'birthday') {
            $result = Customer::where('dob','like','%-' . date('m') . '-%')->get();
            $is_birthday_list = true;
        }
        else {
            $result = Customer::all();
        }

        return view('staff.customer.index', compact('result','is_birthday_list'));
    }

    public function add(Request $request)
    {
        if ($request->method() == 'POST') {
            $inputs = $request->validate([
                'name' => 'required|max:191',
                'tel' => 'required|max:191',
                'email' => 'email|nullable',
                'dob' => 'required|date',
                'address' => 'max:191|nullable',
                'city' => 'required',
                'allergies' => 'nullable',
                'remark' => 'nullable',
                'stylist_id' => 'required|exists:stylists,id',
            ]);

            $inputs['dob'] = Carbon::parse($inputs['dob'])->toDateString();
            Customer::create($inputs);

            flash('Record added')->success();
            return redirect()->route('staff.customer');
        } else {
            $stylistList = Stylist::pluck('name','id')->toArray();
            return view('staff.customer.add',compact('stylistList'));
        }

    }

    public function edit($id, Request $request)
    {
        $record = Customer::findOrFail($id);
        if ($request->method() == 'POST') {
            $inputs = $request->validate([
                'name' => 'required|max:191',
                'tel' => 'required|max:191',
                'email' => 'email|nullable',
                'dob' => 'required|date',
                'address' => 'max:191|nullable',
                'city' => 'required',
                'allergies' => 'nullable',
                'remark' => 'nullable',
                'stylist_id' => 'required|exists:stylists,id',
            ]);

            $inputs['dob'] = Carbon::parse($inputs['dob'])->toDateString();
            $record->update($inputs);

            flash('Record updated')->success();
            return redirect()->route('staff.customer');
        } else {
            $stylistList = Stylist::pluck('name','id')->toArray();
            return view('staff.customer.edit', compact('record','stylistList'));
        }
    }

    public function detail($id) {
        $record = Customer::findOrFail($id);
        $activities = $record->activities()->orderBy('created_at','desc')->get();
        $bookings = $record->bookings()->whereIn('status',['Confirmed','Postpone'])->orderBy('booking_date','asc')->get();

        return view('staff.customer.detail',compact('record','activities','bookings'));
    }

    public function activity($id, Request $request)
    {
        $record = CustomerActivity::findOrFail($id);
        if ($request->method() == 'POST') {
            $inputs = $request->validate([
                'remark' => 'required',
                'stylist' => 'required|exists:stylists,id',
            ]);

            $record->remark = $inputs['remark'];
            $record->stylist_id = $inputs['stylist'];
            $record->save();

            flash('Updated')->success();
            return redirect()->route('staff.customer.detail',[$record->customer_id]);
        } else {
            $stylistList = Stylist::pluck('name', 'id')->toArray();
            return view('staff.customer.activity', compact('stylistList', 'record'));
        }
    }
}
