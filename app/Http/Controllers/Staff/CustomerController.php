<?php

namespace App\Http\Controllers\Staff;

use App\Exports\CustomerExport;
use App\Exports\CustomerLogExport;
use App\Models\Customer;
use App\Models\CustomerLog;
use App\Models\Service;
use App\Models\Stylist;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $new = $request->get('new');
        $type = $request->get('type');
        $sort_by = $request->get('sort_by','name');
        $sort = $request->get('sort','asc');
        $page = $request->get('page');
        $search = $request->get('search');
        $from_date = $request->get('from_date');
        $to_date = $request->get('to_date');

        if ($type) {
            $query = Customer::where('dob', 'like', '%-' . date('m') . '-%');
        } else {
            $query = Customer::query();
        }

        if (!empty($from_date) && !empty($to_date)) {
            $query->whereBetween('follow_up_date',[
                Carbon::createFromFormat('d/m/Y', $from_date)->toDateString(),
                Carbon::createFromFormat('d/m/Y', $to_date)->toDateString()
            ]);
        }

        if (!empty($sort_by) && !empty($sort)){
            $query->orderBy($sort_by,$sort);
        }

        if (!empty($search)) {
            $stylist = Stylist::where('name','like',"%$search%")->first();
            if (!empty($stylist)) {
                $query->where('stylist_id',$stylist->id);
            } else {
                $query->where('name','like',"%$search%")
                    ->orWhere('tel','like',"%$search%")
                    ->orWhere('city','like',"%$search%")
                ;
            }
        }

        if (!empty($new)) {
            if ($new == '7days') {
                $query->where('created_at','>',Carbon::now()->subDays(7)->toDateString());
            } else {
                $query->where('created_at','>',Carbon::now()->subDay()->toDateString());
            }
        }

//        $result = $query->paginate(50);
        $result = $query->get();

        return view('staff.customer.index', compact('result', 'type','new','sort_by','sort','page','search','from_date','to_date'));
    }

    public function followUp()
    {
        $from_date = request()->get('from_date');
        $to_date = request()->get('to_date');

        if (!empty($from_date) && !empty($to_date)) {
            $result = Customer::whereBetween('follow_up_date',[
                Carbon::createFromFormat('d/m/Y', $from_date)->toDateString(),
                Carbon::createFromFormat('d/m/Y', $to_date)->toDateString()
            ])->get();
        } else {
            $result = [];
        }

        return view('staff.customer.follow_up', compact('result', 'from_date','to_date'));
    }

    public function followUpUpdate($id) {
        $customer = Customer::findOrFail($id);
        $customer->is_follow_up = 1;
        $customer->save();

        flash('Updated')->success();
        return redirect()->back();
    }

    public function export()
    {
        return Excel::download(new CustomerExport, 'customers - ' . date('d-m-Y') . ".xlsx");
    }

    public function exportCustomerLog($id)
    {
        $customer = Customer::findOrFail($id);
        return Excel::download(new CustomerLogExport($id), $customer->name . ' logs - ' . date('d-m-Y') . ".xlsx");
    }

    public function add(Request $request)
    {
        if ($request->method() == 'POST') {
            $inputs = $request->validate([
                'name' => 'required|max:191',
                'tel' => 'required|max:191',
                'email' => 'email|nullable',
                'gender' => 'in:Female,Male|nullable',
                'follow_up_date' => 'nullable|date_format:d/m/Y',
                'dob' => 'nullable|date_format:d/m/Y',
                'occupation' => 'nullable',
                'address' => 'max:191|nullable',
                'city' => 'required',
                'allergies' => 'nullable',
                'remark' => 'required',
                'handle_by' => 'nullable',
                'stylist_id' => 'required|exists:stylists,id',
            ]);

            if (!empty($inputs['dob'])) {
                $inputs['dob'] = Carbon::createFromFormat('d/m/Y', $inputs['dob']);
            }

            if (!empty($inputs['follow_up_date'])) {
                $inputs['follow_up_date'] = Carbon::createFromFormat('d/m/Y', $inputs['follow_up_date']);
                $inputs['is_follow_up'] = 0;
            }

            Customer::create($inputs);

            flash('Record added')->success();
            return redirect()->route('staff.customer');
        } else {
            $stylistList = Stylist::pluck('name', 'id')->toArray();
            return view('staff.customer.add', compact('stylistList'));
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
                'dob' => 'nullable|date_format:d/m/Y',
                'follow_up_date' => 'nullable|date_format:d/m/Y',
                'occupation' => 'nullable',
                'gender' => 'in:Female,Male|nullable',
                'address' => 'max:191|nullable',
                'city' => 'required',
                'allergies' => 'nullable',
                'remark' => 'nullable',
                'handle_by' => 'nullable',
                'stylist_id' => 'required|exists:stylists,id',
            ]);

            if (!empty($inputs['dob'])) {
                $inputs['dob'] = Carbon::createFromFormat('d/m/Y', $inputs['dob']);
            }

            if (!empty($inputs['follow_up_date'])) {
                $inputs['follow_up_date'] = Carbon::createFromFormat('d/m/Y', $inputs['follow_up_date']);
                $inputs['is_follow_up'] = 0;
            }

            $record->update($inputs);

            flash('Record updated')->success();
            return redirect()->route('staff.customer');
        } else {
            $stylistList = Stylist::pluck('name', 'id')->toArray();
            return view('staff.customer.edit', compact('record', 'stylistList'));
        }
    }

    public function detail($id)
    {
        $record = Customer::findOrFail($id);
        $logs = $record->logs()->orderBy('log_date', 'desc')->get();
        $bookings = $record->bookings()->whereIn('status', ['Confirmed', 'Postpone'])->orderBy('booking_date', 'asc')->get();

        return view('staff.customer.detail', compact('record', 'logs', 'bookings'));
    }

    public function editLog($id, Request $request)
    {
        $record = CustomerLog::findOrFail($id);
        if ($request->method() == 'POST') {
            $inputs = $request->validate([
                'remark' => 'nullable',
                'log_date' => 'required',
                'log_time' => 'required',
                'services' => 'required|array',
                'products' => 'nullable',
                'handle_by' => 'nullable',
                'total' => 'required|numeric',
                'stylist' => 'required|exists:stylists,id',
            ]);

            $datetime = Carbon::createFromFormat('d/m/Y g:i A', $inputs['log_date'] . ' ' . $inputs['log_time']);
            $this->recordCustomerLastVisit($record->customer_id, $datetime->toDateTimeString());
            $record->remark = $inputs['remark'];
            $record->products = $inputs['products'];
            $record->stylist_id = $inputs['stylist'];
            $record->services = implode(', ', Service::whereIn('id', $inputs['services'])->pluck('name')->toArray());
            $record->total = $inputs['total'];
            $record->handle_by = $inputs['handle_by'];
            $record->log_date = $datetime->toDateTimeString();
            $record->services_id = implode(',', $inputs['services']);
            $record->save();

            flash('Updated')->success();
            return redirect()->route('staff.customer.detail', [$record->customer_id]);
        } else {
            $stylistList = Stylist::pluck('name', 'id')->toArray();
            $serviceList = Service::pluck('name', 'id')->toArray();
            $services = explode(',', $record->services_id);
            return view('staff.customer.log_edit', compact('stylistList', 'record', 'serviceList', 'services'));
        }
    }

    public function deleteLog($id)
    {
        $record = CustomerLog::findOrFail($id);
        $record->delete();

        flash('Record deleted')->warning()->important();
        return redirect()->back();
    }

    public function addLog($customer_id, Request $request)
    {
        if ($request->method() == 'POST') {
            $inputs = $request->validate([
                'remark' => 'nullable',
                'log_date' => 'required',
                'log_time' => 'required',
                'services' => 'required|array',
                'products' => 'nullable',
                'handle_by' => 'nullable',
                'total' => 'required|numeric',
                'stylist' => 'required|exists:stylists,id',
            ]);

            $record = new CustomerLog();
            $datetime = Carbon::createFromFormat('d/m/Y g:i A', $inputs['log_date'] . ' ' . $inputs['log_time']);
            $this->recordCustomerLastVisit($customer_id, $datetime->toDateTimeString());
            $record->remark = $inputs['remark'];
            $record->products = $inputs['products'];
            $record->stylist_id = $inputs['stylist'];
            $record->services = implode(', ', Service::whereIn('id', $inputs['services'])->pluck('name')->toArray());
            $record->total = $inputs['total'];
            $record->handle_by = $inputs['handle_by'];
            $record->customer_id = $customer_id;
            $record->log_date = $datetime->toDateTimeString();
            $record->services_id = implode(',', $inputs['services']);
            $record->save();

            flash('Added')->success();
            return redirect()->route('staff.customer.detail', [$record->customer_id]);
        } else {
            $stylistList = Stylist::pluck('name', 'id')->toArray();
            $serviceList = Service::pluck('name', 'id')->toArray();
            $customer = Customer::FindOrFail($customer_id);
            return view('staff.customer.log_add', compact('stylistList', 'serviceList', 'customer'));
        }
    }

    public function sms(Request $request)
    {

        if ($request->method() == 'POST') {
            $inputs = $request->validate([
                'title' => 'required',
                'customer_group' => 'required',
                'message' => 'required',
                'id' => 'required_if:customer_group,id',
            ]);

            $tels = [];
            switch ($inputs['customer_group']) {
                case 'male':
                    $tels = Customer::where('gender', 'Male')->pluck('tel')->toArray();
                    break;
                case 'female':
                    $tels = Customer::where('gender', 'Female')->pluck('tel')->toArray();
                    break;
                case 'birthday':
                    $tels = Customer::where('dob', 'like', '%-' . date('m') . '-%')->pluck('tel')->toArray();
                    break;
                case 'all':
                    $tels = Customer::pluck('tel')->toArray();
                    break;
                case 'id':
                    $tels = Customer::where('id',$inputs['id'])->pluck('tel')->toArray();
                    break;
            }


            if (!empty($tels)) {
                $key = 'sms_blast||' . time() . '||' . Str::slug($inputs['title']);
                foreach ($tels as $tel) {
                    Redis::command('SADD', [$key, $tel . '||' . $inputs['message'] . '||0']);
                }
            }

            flash('Blast created, a total ' . count($tels) . ' SMS is sending now...')->success();
            return redirect()->route('staff.customer.sms_blast');
        } else {
            $id = request()->get('id');
            $blast_list_raw = Redis::keys('sms_blast||*');
            $blast_list = [];
            foreach ($blast_list_raw as $item) {
                $blast_arr = explode('||', $item);
                $blast_list[] = [
                    'key' => $item,
                    'title' => $blast_arr[2],
                    'created_at' => Carbon::createFromTimestamp($blast_arr[1])->toDayDateTimeString(),
                    'count' => Redis::command('SCARD', [$item])
                ];
            }

            $blast_fail_list_raw = Redis::command('SMEMBERS', ['sms_blast_fail']);
            $blast_fail_list = [];
            foreach ($blast_fail_list_raw as $item) {
                $blast_fail_arr = explode('||', $item);
                $blast_fail_list[] = [
                    'tel' => $blast_fail_arr[0],
                    'message' => $blast_fail_arr[1],
                    'retry' => $blast_fail_arr[2]
                ];
            }

            $customers = Customer::all();
            $count_female = $customers->where('gender', 'Female')->count();
            $count_male = $customers->where('gender', 'Male')->count();
            $count_all = $customers->count();
            $count_birthday = Customer::where('dob', 'like', '%-' . date('m') . '-%')->count();

            $sms_balance = 0;
            if (!empty(env('SMS_USERNAME')) && !empty(env('SMS_BALANCE_URL'))) {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, env('SMS_BALANCE_URL') . '?apiusername=' . env('SMS_USERNAME') . '&apipassword=' . env('SMS_PASSWORD'));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                $sms_balance = curl_exec($ch);
                curl_close($ch);
            }

            return view('staff.customer.sms_blast', compact('blast_list', 'blast_fail_list', 'count_all', 'count_female', 'count_male', 'count_birthday', 'sms_balance','id'));
        }
    }

    public function deleteSms($key)
    {
        Redis::del($key);
        flash('Record deleted')->warning()->important();
        return redirect()->back();
    }

    public function deleteCustomer($id)
    {
        Customer::destroy($id);
        flash('Customer deleted')->warning()->important();
        return redirect()->route('staff.customer');
    }

    private function recordCustomerLastVisit($customer_id, $date)
    {
        $customer = Customer::find($customer_id);
        if (!empty($customer)) {
            $customer_last_visit = $customer->last_log();
            if (!empty($customer_last_visit) && $customer_last_visit->log_date < $date) {
                $customer->last_visit_at = $date;
                $customer->save();
            }
        }
    }
}
