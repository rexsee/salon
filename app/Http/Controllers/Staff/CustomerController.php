<?php

namespace App\Http\Controllers\Staff;

use App\Models\Customer;
use App\Models\CustomerActivity;
use App\Models\Stylist;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redis;

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
                'gender' => 'in:Female,Male|nullable',
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
                'gender' => 'in:Female,Male|nullable',
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

    public function sms(Request $request) {

        if($request->method() == 'POST') {
            $inputs = $request->validate([
                'title'=>'required',
                'customer_group'=>'required',
                'message'=>'required',
            ]);

            $tels = [];
            switch ($inputs['customer_group']) {
                case 'male':
                    $tels = Customer::where('gender','Male')->pluck('tel')->toArray();
                    break;
                case 'female':
                    $tels = Customer::where('gender','Female')->pluck('tel')->toArray();
                    break;
                case 'birthday':
                    $tels = Customer::where('dob','like','%-' . date('m') . '-%')->pluck('tel')->toArray();
                    break;
                case 'all':
                    $tels = Customer::pluck('tel')->toArray();
                    break;
            }

            if (!empty($tels)) {
                $key = 'sms_blast||' . time() . '||' . str_slug($inputs['title']);
                foreach ($tels as $tel){
                    Redis::command('SADD', [$key, $tel . '||' . $inputs['message'] . '||0']);
                }
            }

            flash('Blast created, a total ' . count($tels) . ' SMS is sending now...')->success();
            return redirect()->route('staff.customer.sms_blast');
        }
        else {
            $blast_list_raw = Redis::keys('sms_blast||*');
            $blast_list = [];
            foreach ($blast_list_raw as $item)
            {
                $blast_arr = explode('||',$item);
                $blast_list[] = [
                    'key' => $item,
                    'title' => $blast_arr[2],
                    'created_at' => Carbon::createFromTimestamp($blast_arr[1])->toDayDateTimeString(),
                    'count' => Redis::command('SCARD',[$item])
                ];
            }

            $blast_fail_list_raw = Redis::command('SMEMBERS',['sms_blast_fail']);
            $blast_fail_list = [];
            foreach ($blast_fail_list_raw as $item) {
                $blast_fail_arr = explode('||',$item);
                $blast_fail_list[] = [
                    'tel' => $blast_fail_arr[0],
                    'message' => $blast_fail_arr[1],
                    'retry' => $blast_fail_arr[2]
                ];
            }

            $customers = Customer::all();
            $count_female = $customers->where('gender','Female')->count();
            $count_male = $customers->where('gender','Male')->count();
            $count_all = $customers->count();
            $count_birthday = Customer::where('dob','like','%-' . date('m') . '-%')->count();

            if(!empty(env('SMS_USERNAME')) && !empty(env('SMS_BALANCE_URL'))){
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, env('SMS_BALANCE_URL') . '?apiusername='.env('SMS_USERNAME').'&apipassword='.env('SMS_PASSWORD'));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                $sms_balance = curl_exec($ch);
                curl_close($ch);
            }

            return view('staff.customer.sms_blast',compact('blast_list','blast_fail_list','count_all','count_female','count_male','count_birthday','sms_balance'));
        }
    }

    public function deleteSms($key) {
        Redis::del($key);
        flash('Record deleted')->warning()->important();
        return redirect()->back();
    }
}
