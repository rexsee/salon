<?php

namespace App\Http\Controllers\Staff;

use App\Exports\CustomerLogExport;
use App\Exports\ExportLib;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerLog;
use App\Models\Service;
use App\Models\Stylist;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller
{
    protected $presetActiveLink;

    public function __construct()
    {
        $this->presetActiveLink = route('staff.customer');
    }

    public function index(Request $request)
    {
        $stylists = Stylist::pluck('name','id')->toArray();
        $filterItems = [
            'keyword' => ['type' => 'text', 'display_name' => 'Search'],
            'created_at' => ['type' => 'daterange', 'display_name' => 'Created Date'],
            'logged_at' => ['type' => 'daterange', 'display_name' => 'Visited Date'],
            'follow_up_date' => ['type' => 'daterange', 'display_name' => 'Follow Up Date'],
            'category' => ['type' => 'select', 'options' => ['' => '-- All Category --', 'first'=>'First Time', 'birthday'=>'Birthday'] + getCustomerCategory()],
            'gender' => ['type' => 'select', 'options' => ['' => '-- All Gender --', 'Male' => 'Male', 'Female' => 'Female']],
            'stylist' => ['type' => 'select', 'options' => ['' => '-- All Stylist --'] + $stylists],
        ];
        $filterSelected = $this->validate($request, [
            'keyword' => 'nullable',
            'created_at' => 'nullable',
            'logged_at' => 'nullable',
            'follow_up_date' => 'nullable',
            'category' => 'nullable',
            'type' => 'nullable',
            'gender' => 'nullable',
            'stylist' => 'nullable',
            'order_by' => 'nullable',
            'order_type' => 'nullable',
        ]);

        if (empty($filterSelected['order_by'])) {
            $filterSelected['order_by'] = 'created_at';
        }

        $query = $this->getListQuery($filterSelected);
        $data = $query->paginate(50);
        $page_title = 'Customer';
        $add_link = route('staff.customer.add');
        $presetActiveLink = $this->presetActiveLink;
        return view('admin.customer.list', compact('presetActiveLink','data', 'page_title', 'add_link', 'filterItems', 'filterSelected'));
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

    public function export(Request $request, $islog = 0)
    {
        $filterSelected = $this->validate($request, [
            'keyword' => 'nullable',
            'created_at' => 'nullable',
            'logged_at' => 'nullable',
            'follow_up_date' => 'nullable',
            'type' => 'nullable',
            'gender' => 'nullable',
            'stylist' => 'nullable',
            'order_by' => 'nullable',
            'order_type' => 'nullable',
            'islog' => 'boolean',
        ]);

        if (empty($filterSelected['order_by'])) {
            $filterSelected['order_by'] = 'created_at';
        }

        $query = $this->getListQuery($filterSelected, $islog);
        $rawData = $query->get()->toArray();

        if (!empty($rawData)) {
            $data = [];
            foreach ($rawData as $item) {
                unset($item['id']);
                unset($item['stylist_id']);
                unset($item['is_follow_up']);
                unset($item['deleted_at']);
                $data[] = $item;
            }

            foreach (array_keys($data[0]) as $item) {
                $item = str_replace('_', ' ', $item);
                $headers[0][] = ucwords($item);
            }
            $data = array_merge($headers, $data);
            $export = new ExportLib($data);
            $file_name = ($islog ? 'customer_logs_' : 'customers_')  . date('YmdHi');

            return Excel::download($export, "$file_name.xlsx", \Maatwebsite\Excel\Excel::XLSX);
        } else {
            session()->flash('noty', 'No data found');
            session()->flash('notyType', 'error');
            return redirect()->back();
        }
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
                'category' => 'nullable',
                'occupation' => 'nullable',
                'address' => 'max:191|nullable',
                'city' => 'required',
                'allergies' => 'nullable',
                'remark' => 'nullable|string|max:255',
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
                'category' => 'nullable',
                'occupation' => 'nullable',
                'gender' => 'in:Female,Male|nullable',
                'address' => 'max:191|nullable',
                'city' => 'required',
                'allergies' => 'nullable',
                'remark' => 'nullable|string|max:255',
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

    private function getListQuery($filterSelected = [], $isWithLogDetail = false) {
        $query = Customer::query();
        $query->leftJoin('customer_logs','customers.id','=','customer_logs.customer_id');
        $query->leftJoin('stylists',($isWithLogDetail ? 'customer_logs' : 'customers') . '.stylist_id','=','stylists.id');

        if ($isWithLogDetail) {
            $query->select(DB::raw('customers.name as customer_name, customers.tel as customer_tel, customer_logs.log_date, customer_logs.services, customer_logs.products, customer_logs.remark as log_remark, customer_logs.total, stylists.name as stylist_name, customer_logs.handle_by'));
        } else {
            $query->select(DB::raw('customers.*, stylists.name as stylist_name, count(customer_logs.id) as visit_count, sum(customer_logs.total) as total_spent'));
            $query->groupBy('customers.id');
        }

        if (!empty($filterSelected['keyword'])) {
            $query->where(function ($query) use ($filterSelected) {
                $keywords = explode(' ',$filterSelected['keyword']);

                foreach ($keywords as $k => $v) {
                    if ($k == 0) {
                        $query->where('customers.name', 'like', "%$v%")
                            ->orWhere('customers.tel', 'like',  "%$v%")
                            ->orWhere('customers.remark', 'like', "%$v%");
                    } else {
                        $query->orWhere('customers.name', 'like', "%$v%")
                            ->orWhere('customers.tel', 'like',  "%$v%")
                            ->orWhere('customers.remark', 'like', "%$v%");
                    }
                }
            });
        }

        /*
        if (!empty($filterSelected['type'])) {
            if ($filterSelected['type'] == 'first') {
                $query->where('visit_count', '=', 1);
            } elseif ($filterSelected['type'] == 'birthday') {

            }
        }
        */
        if (!empty($filterSelected['category'])) {
            if ($filterSelected['category'] == 'birthday') {
                $query->where('dob', 'like', '%-' . date('m') . '-%');
            } elseif($filterSelected['category'] == 'first') {
                $query->havingRaw('count(customer_logs.id) = 1');
            } else {
                $query->where('customers.category','=',$filterSelected['category']);
            }
        }
        if (!empty($filterSelected['gender'])) {
            $query->where('gender','=',$filterSelected['gender']);
        }

        if (!empty($filterSelected['stylist'])) {
            $query->where('customers.stylist_id','=',$filterSelected['stylist']);
        }

        if (!empty($filterSelected['created_at'])) {
            $dates = getFormattedDateRange($filterSelected['created_at']);
            $query->whereBetween('customers.created_at', $dates);
        }

        if (!empty($filterSelected['logged_at'])) {
            $dates = getFormattedDateRange($filterSelected['logged_at']);
            $query->whereBetween('customer_logs.log_date', $dates);
        }

        if (!empty($filterSelected['follow_up_date'])) {
            $dates = getFormattedDateRange($filterSelected['follow_up_date']);
            $query->whereBetween('follow_up_date', $dates);
        }

        if ($isWithLogDetail) {
            $query->orderBy('customers.id', 'ASC');
            $query->orderBy('log_date', 'DESC');
        } else {
            if (!empty($filterSelected['order_by'])) {
                $orderType = empty($filterSelected['order_type']) ? 'DESC' : $filterSelected['order_type'];
                $query->orderBy($filterSelected['order_by'], $orderType);
            }
        }

        return $query;
    }
}
