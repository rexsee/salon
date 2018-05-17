<?php

namespace App\Http\Controllers\Staff;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Service;
use App\Models\Stylist;
use App\Models\SystemInformation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Laracasts\Flash\Flash;

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
                'name' => 'required|max:191',
                'tel' => 'required|max:191',
                'book_date' => 'required',
                'book_time' => 'required',
                'services' => 'required|array',
                'stylist' => 'required|exists:stylists,id',
            ]);

            $datetime = Carbon::createFromFormat('d/m/Y g:i A',$inputs['book_date'] . ' ' .$inputs['book_time']);
            if($datetime->format('N') == 2) {
                return redirect()->back()->withInput()->withErrors('Booking date is no in the business day.');
            }

            if($datetime->format('H') < 11 || $datetime->format('H') > 20) {
                return redirect()->back()->withInput()->withErrors('Booking time is no in the business hour.');
            }

            $services_string = '';
            $services_id = '';
            $minutes_take = 0;
            $tel = starts_with($inputs['tel'], '60') ? substr($inputs['tel'], 1) : $inputs['tel'];
            foreach ($inputs['services'] as $service_id) {
                $service = Service::findOrFail($service_id);
                $services_string .= $service->name . ', ';
                $services_id .= $service->id . ',';
                $minutes_take += $service->minutes_needed;
            }
            $check_double_booking = Booking::where('name', $inputs['name'])
                ->where('status', 'Pending')
                ->where('tel', $tel)
                ->where('booking_date', $datetime->toDateTimeString())
                ->where('services_id', substr($services_id, 0, -1))
                ->where('stylist_id', $inputs['stylist'])
                ->first();

            if (empty($check_double_booking)) {
                $check_status = check_stylist_availability($inputs['stylist'], $datetime, $minutes_take, true);
                if ($check_status['status'] == false) {
                    Flash::error('Selected date time is not available. ' . $check_status['remark'])->important();
                    return redirect()->back()->withInput();
                }

                $customer = Customer::where('tel',$tel)->first();
                if(empty($customer)) {
                    $customer = new Customer();
                    $customer->tel = $tel;
                    $customer->name = $inputs['name'];
                    $customer->stylist_id = $inputs['stylist'];
                    $customer->save();
                }

                $booking = new Booking();
                $booking->name = $inputs['name'];
                $booking->tel = $tel;
                $booking->booking_date = Carbon::createFromFormat('d/m/Y g:i A',$inputs['book_date'] . ' ' .$inputs['book_time'])->toDateTimeString();
                $booking->services = substr($services_string, 0, -2);
                $booking->services_id = substr($services_id, 0, -1);
                $booking->minutes_take = $minutes_take;
                $booking->stylist_id = $inputs['stylist'];
                $booking->customer_id = $customer->id;
                $booking->save();

                if(!empty(env('SMS_USERNAME')) && !empty(env('SMS_MT_URL'))){
                    $system_info = SystemInformation::first();
                    $support_tels = explode(',',$system_info->contact_number);
                    $support_tel = str_replace(' ','',$support_tels[0]);
                    $support_tel = str_replace('-','',$support_tel);
                    $support_tel = str_replace('+','',$support_tel);
                    $message = urlencode('Your booking at ' . env('APP_NAME') . ' on '. $datetime->toDayDateTimeString() . ' is confirmed. Please call us at '.$support_tel.' if you need to modify your booking.');

                    $sms_url = env('SMS_MT_URL') . '?';
                    $sms_url.= 'apiusername=' . env('SMS_USERNAME');
                    $sms_url.= '&apipassword=' . env('SMS_PASSWORD');
                    $sms_url.= '&mobileno=6' . $tel;
                    $sms_url.= '&senderid=INFO';
                    $sms_url.= '&languagetype=1';
                    $sms_url.= '&message=' . $message;

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $sms_url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                    $sms_result = curl_exec($ch);
                    curl_close($ch);

                    if (empty($sms_result) || $sms_result != '200'){
                        Log::error('SMS_MT | ' . $sms_result . ' | ' . $sms_url);
                    }
                }
            }
            flash('Booking added')->success();
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

                if(!empty(env('SMS_USERNAME')) && !empty(env('SMS_MT_URL'))){
                    $message = urlencode('Your booking at ' . env('APP_NAME') . ' is updated to '. $record->booking_date->toDayDateTimeString());

                    $sms_url = env('SMS_MT_URL') . '?';
                    $sms_url.= 'apiusername=' . env('SMS_USERNAME');
                    $sms_url.= '&apipassword=' . env('SMS_PASSWORD');
                    $sms_url.= '&mobileno=6' . $record->customer->tel;
                    $sms_url.= '&senderid=INFO';
                    $sms_url.= '&languagetype=1';
                    $sms_url.= '&message=' . $message;

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $sms_url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                    $sms_result = curl_exec($ch);
                    curl_close($ch);

                    if (empty($sms_result) || $sms_result != '200'){
                        Log::error('SMS_MT | ' . $sms_result . ' | ' . $sms_url);
                    }
                }
            }
            $record->save();

            flash('Record updated')->success();
            return redirect()->route('staff.booking');
        } else {
            return view('staff.booking.update', compact('record'));
        }
    }
}
