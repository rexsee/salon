<?php
namespace App\Exports;

use App\Models\Customer;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CustomerLogExport implements FromView
{
    protected $customerId;
    public function __construct(int $customerId)
    {
        $this->customerId = $customerId;
    }

    public function view(): View
    {
        $customer = Customer::findOrFail($this->customerId);
        return view('exports.customerLogs', [
            'customerLogs' => $customer->logs()->orderBy('log_date')->get()
        ]);
    }
}
