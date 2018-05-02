<?php

namespace App\Http\Controllers\Staff;

use App\Models\Booking;
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
        if(Input::get('type') == 'pending') {
            $result = Booking::where('type','Pending')->get();
            $is_pending_list = true;
        }
        else {
            $result = Booking::all();
        }



        return view('staff.booking.index', compact('result','is_pending_list'));
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
            $stylistList = Stylist::pluck('name','id')->toArray();
            $service = Service::orderBy('name')->get();
            $color_services = $service->where('type', 'cat-color')->pluck('name', 'id')->toArray();
            $basic_services = $service->where('type', 'cat-basics')->pluck('name', 'id')->toArray();
            $serviceList['Color'] = $color_services;
            $serviceList['Basic'] = $basic_services;
            return view('staff.booking.add',compact('stylistList','serviceList'));
        }
    }

    public function edit($id, Request $request)
    {
        $record = Booking::findOrFail($id);
        if ($request->method() == 'POST') {
            $inputs = $request->validate([
                'status' => 'required',
                'hour' => 'require_if:status:Confirmed',
                'is_sms_notify' => 'require_if:status:Confirmed',
            ]);

            $record->update($inputs);

            flash('Record updated')->success();
            return redirect()->route('staff.booking');
        } else {
            return view('staff.booking.edit', compact('record','stylistList'));
        }
    }
}
