<?php

namespace App\Http\Controllers\Staff;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Service;
use App\Models\Stylist;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class BookingController extends Controller
{
    public function index()
    {
        $result = Booking::whereIn('status', ['Confirmed', 'Postpone'])->get();

        return view('staff.booking.index', compact('result'));
    }

    public function add(Request $request)
    {
        if ($request->method() == 'POST') {
            $inputs = $request->validate([
                'status' => 'required',
                'name' => 'required|max:191',
                'tel' => 'required|max:191',
                'bdate' => 'required|date',
                'services' => 'required|array',
                'stylist_id' => 'required|exists:stylists,id',
            ]);

            $inputs['booking_date'] = Carbon::parse($inputs['bdate'])->toDateTimeString();
            Booking::create($inputs);

            flash('Record added')->success();
            return redirect()->route('staff.booking');
        } else {
            $customer_id = Input::get('id');
            if (!empty($customer_id)) {
                $customer = Customer::find($customer_id);
            }
            $stylistList = Stylist::pluck('name', 'id')->toArray();
            $serviceList = Service::pluck('name','id')->toArray();
            return view('staff.booking.add', compact('stylistList', 'serviceList', 'customer'));
        }
    }

    public function update($id, Request $request)
    {
        $record = Booking::where('id', $id)->whereIn('status', ['Confirmed', 'Postpone'])->firstOrFail();
        if ($request->method() == 'POST') {
            $inputs = $request->validate([
                'update_to' => 'required|in:Postpone,Cancel',
                'postpone_date' => 'required_if:update_to,Postpone',
                'postpone_time' => 'required_if:update_to,Postpone',
            ]);

            $record->status = $inputs['update_to'];
            if ($inputs['update_to'] == 'Postpone') {
                $to_date = $inputs['postpone_date'] . ' ' . $inputs['postpone_time'];
                $record->booking_date = Carbon::createFromFormat('d/m/Y g:i A', $to_date)->toDateTimeString();
            }
            $record->save();

            flash('Record updated')->success();
            return redirect()->route('staff.booking');
        } else {
            return view('staff.booking.update', compact('record'));
        }
    }
}
