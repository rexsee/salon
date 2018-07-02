<?php

namespace App\Http\Controllers\Staff;

use App\Models\Customer;
use App\Models\CustomerLog;
use App\Models\Service;
use App\Models\Stylist;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redis;
use Maatwebsite\Excel\Facades\Excel;

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

    public function export()
    {
        $result = Customer::all();
        $format = Input::get('format','xlsx');

        Excel::create('customers - ' . date('d-m-Y'), function ($excel) use ($result) {
            $excel->sheet('customers', function ($sheet) use ($result) {
                $sheet->freezeFirstRow();
                $sheet->setColumnFormat(['A:L' => '@']);
                $sheet->row(1, [
                    'Name',
                    'Tel.',
                    'Email',
                    'Gender',
                    'DOB',
                    'Birthday Month',
                    'Address',
                    'City',
                    'Handle By',
                    'Stylist',
                    'Allergies',
                    'Remark',
                    'Total Visit',
                    'Total Spent'
                ]);
                $row = 2;

                foreach ($result as $entry) {
                    $sheet->row($row, [
                        $entry->name,
                        $entry->tel,
                        $entry->email,
                        $entry->gender,
                        empty($entry->dob) ? '-' : $entry->dob->toDateString(),
                        empty($entry->dob) ? '-' : $entry->dob->format('F'),
                        $entry->address,
                        $entry->city,
                        $entry->handle_by,
                        $entry->stylist->name,
                        $entry->allergies,
                        $entry->remark,
                        $entry->logs()->count(),
                        $entry->logs()->sum('total'),
                    ]);
                    $row++;
                }

                $sheet->row(1, function ($row) {
                    $row->setBackground('#337AB7');
                    $row->setFontColor('#ffffff');
                    $row->setAlignment('center');
                });

            });
            $excel->setTitle('Customer');
        })->export($format);
    }

    public function exportCustomerLog($id)
    {
        $customer = Customer::findOrFail($id);
        $result = $customer->logs()->orderBy('log_date')->get();
        $format = Input::get('format','xlsx');

        Excel::create($customer->name . ' logs ' . date('d-m-Y'), function ($excel) use ($result) {
            $excel->sheet('customers', function ($sheet) use ($result) {
                $sheet->freezeFirstRow();
                $sheet->setColumnFormat(['A:F' => '@']);
                $sheet->row(1, ['Date', 'Services','Handle By','Stylist', 'Remark', 'Product', 'Total Price']);
                $row = 2;

                foreach ($result as $entry) {
                    $sheet->row($row, [
                        $entry->log_date->toDayDateTimeString(),
                        $entry->services,
                        $entry->handle_by,
                        $entry->stylist->name,
                        $entry->remark,
                        $entry->product,
                        $entry->total,
                    ]);
                    $row++;
                }

                $sheet->row(1, function ($row) {
                    $row->setBackground('#337AB7');
                    $row->setFontColor('#ffffff');
                    $row->setAlignment('center');
                });

            });
            $excel->setTitle('Customer');
        })->export($format);
    }

    public function add(Request $request)
    {
        if ($request->method() == 'POST') {
            $inputs = $request->validate([
                'name' => 'required|max:191',
                'tel' => 'required|max:191',
                'email' => 'email|nullable',
                'gender' => 'in:Female,Male|nullable',
                'dob' => 'nullable|date',
                'address' => 'max:191|nullable',
                'city' => 'required',
                'allergies' => 'nullable',
                'remark' => 'nullable',
                'handle_by' => 'nullable',
                'stylist_id' => 'required|exists:stylists,id',
            ]);

            if (!empty($inputs['dob'])) {
                $inputs['dob'] = Carbon::parse($inputs['dob'])->toDateString();
            }
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
                'dob' => 'nullable|date',
                'gender' => 'in:Female,Male|nullable',
                'address' => 'max:191|nullable',
                'city' => 'required',
                'allergies' => 'nullable',
                'remark' => 'nullable',
                'handle_by' => 'nullable',
                'stylist_id' => 'required|exists:stylists,id',
            ]);

            if (!empty($inputs['dob'])) {
                $inputs['dob'] = Carbon::parse($inputs['dob'])->toDateString();
            }
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
        $logs = $record->logs()->orderBy('log_date','desc')->get();
        $bookings = $record->bookings()->whereIn('status',['Confirmed','Postpone'])->orderBy('booking_date','asc')->get();

        return view('staff.customer.detail',compact('record','logs','bookings'));
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

            $datetime = Carbon::createFromFormat('d/m/Y g:i A',$inputs['log_date'] . ' ' .$inputs['log_time']);
            $record->remark = $inputs['remark'];
            $record->products = $inputs['products'];
            $record->stylist_id = $inputs['stylist'];
            $record->services = implode(', ',Service::whereIn('id',$inputs['services'])->pluck('name')->toArray());
            $record->total = $inputs['total'];
            $record->handle_by = $inputs['handle_by'];
            $record->log_date = $datetime->toDateTimeString();
            $record->services_id = implode(',',$inputs['services']);
            $record->save();

            flash('Updated')->success();
            return redirect()->route('staff.customer.detail',[$record->customer_id]);
        } else {
            $stylistList = Stylist::pluck('name', 'id')->toArray();
            $serviceList = Service::pluck('name','id')->toArray();
            $services = explode(',',$record->services_id);
            return view('staff.customer.log_edit', compact('stylistList', 'record', 'serviceList', 'services'));
        }
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
            $datetime = Carbon::createFromFormat('d/m/Y g:i A',$inputs['log_date'] . ' ' .$inputs['log_time']);
            $record->remark = $inputs['remark'];
            $record->products = $inputs['products'];
            $record->stylist_id = $inputs['stylist'];
            $record->services = implode(', ',Service::whereIn('id',$inputs['services'])->pluck('name')->toArray());
            $record->total = $inputs['total'];
            $record->handle_by = $inputs['handle_by'];
            $record->customer_id = $customer_id;
            $record->log_date = $datetime->toDateTimeString();
            $record->services_id = implode(',',$inputs['services']);
            $record->save();

            flash('Added')->success();
            return redirect()->route('staff.customer.detail',[$record->customer_id]);
        } else {
            $stylistList = Stylist::pluck('name', 'id')->toArray();
            $serviceList = Service::pluck('name','id')->toArray();
            $customer = Customer::FindOrFail($customer_id);
            return view('staff.customer.log_add', compact('stylistList', 'serviceList','customer'));
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
