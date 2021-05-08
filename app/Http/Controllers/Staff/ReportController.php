<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerLog;
use App\Models\Stylist;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function sales(Request $request)
    {
        $salesYear = (int)$request->get('sales',date('Y'));
        $handleYear = (int)$request->get('handle',date('Y'));

        $visit = [];
        $amount = [];
        $dates = [];
        for ($i = 11; $i >= 0; $i--) {
            $start = Carbon::now()->subMonths($i)->startOfMonth();
            $end = Carbon::now()->subMonths($i)->endOfMonth();
            $dateName = Carbon::now()->subMonths($i)->format('M `y');

            $count = CustomerLog::whereBetween('log_date', [$start, $end])->count();
            $visit[$dateName] = $count;

            $sum = CustomerLog::whereBetween('log_date', [$start, $end])->sum('total');
            $amount[$dateName] = $sum;

            $dates[] = $dateName;
        }

        $topHandle = CustomerLog::select(DB::raw('handle_by, count(*) as total'))
            ->whereBetween('created_at',["$handleYear-01-01 00:00:00","$handleYear-12-31 23:59:59"])
            ->groupBy('handle_by')
            ->orderBy('total', 'DESC')
            ->limit(5)
            ->pluck('total','handle_by')
            ->toArray();

        $stylists = Stylist::pluck('name', 'id');
        $topSalesRaw = CustomerLog::select(DB::raw('stylist_id, sum(customer_logs.total) as total'))
            ->whereBetween('created_at',["$salesYear-01-01 00:00:00","$salesYear-12-31 23:59:59"])
            ->groupBy('stylist_id')
            ->orderBy('total', 'DESC')
            ->limit(5)
            ->get();
        $topSales = [];
        foreach ($topSalesRaw as $item) {
            if (!empty($stylists[$item->stylist_id])) {
                $topSales[$stylists[$item->stylist_id]] = $item->total;
            }
        }
        return view('staff.report.sales', compact('dates', 'salesYear','handleYear','amount', 'visit', 'topSales', 'topHandle'));
    }

    public function customer()
    {
        $cityDataRaw = Customer::select(DB::raw('count(*) as total, city'))->groupBy('city')->orderBy('city')->get();
        $cityData = [];
        foreach ($cityDataRaw as $item) {
            if (empty($item->city)) {
                $cityData['Unknown'] = $item->total;
            } else {
                $cityData[$item->city] = $item->total;
            }
        }

        $genderDataRaw = Customer::select(DB::raw('count(*) as total, gender'))->groupBy('gender')->orderBy('gender')->get();
        $genderData = [];
        foreach ($genderDataRaw as $item) {
            if (empty($item->gender)) {
                $genderData['Unknown'] = $item->total;
            } else {
                $genderData[$item->gender] = $item->total;
            }
        }

        $categoryDataRaw = Customer::select(DB::raw('count(*) as total, category'))->groupBy('category')->orderBy('category')->get();
        $categoryData = [];
        foreach ($categoryDataRaw as $item) {
            if (empty($item->category)) {
                $categoryData['Unknown'] = $item->total;
            } else {
                $categoryData[$item->category] = $item->total;
            }
        }

        $stylists = Stylist::pluck('name', 'id');
        $stylistDataRaw = Customer::select(DB::raw('count(*) as total, stylist_id'))->groupBy('stylist_id')->orderBy('stylist_id')->get();
        $stylistData = [];
        foreach ($stylistDataRaw as $item) {
            if (empty($item->stylist)) {
                $stylistData['Unknown'] = $item->total;
            } else {
                $stylistData[$stylists[$item->stylist_id] ?? 'No Name'] = $item->total;
            }
        }


        $register = [];
        for ($i = 11; $i >= 0; $i--) {
            $count = Customer::whereBetween('created_at', [Carbon::now()->subMonths($i)->startOfMonth(), Carbon::now()->subMonths($i)->endOfMonth()])->count();
            $register[Carbon::now()->subMonths($i)->format('M `y')] = $count;
        }
        return view('staff.report.customer', compact('register', 'cityData', 'genderData', 'categoryData', 'stylistData'));
    }
}
