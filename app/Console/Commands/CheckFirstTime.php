<?php

namespace App\Console\Commands;

use App\Models\Customer;
use App\Models\CustomerLog;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckFirstTime extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:firsttime';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send SMS to first time customer';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $customers = CustomerLog::select(DB::raw('count(*) as total, customer_id, customers.tel, customers.name'))
            ->leftJoin('customers','customers.id','=','customer_logs.customer_id')
            ->havingRaw('count(*) = 1')
            ->whereBetween('log_date',[Carbon::now()->subDays(3)->startOfDay(), Carbon::now()->subDays(3)->endOfDay()])
            ->groupBy('customer_id')
            ->get();

        $sentCount = 0;
        foreach ($customers as $customer) {
            if(!empty(env('SMS_USERNAME')) && !empty(env('SMS_MT_URL'))){
                $message = urlencode('RM0.00 ALPH STUDIO: Thanks for your 1st visit, and we appreciate any feedback so proper follow up can be arranged. Just WhatsApp/call +6016-4891212');

                $sms_url = env('SMS_MT_URL') . '?';
                $sms_url.= 'apiusername=' . env('SMS_USERNAME');
                $sms_url.= '&apipassword=' . env('SMS_PASSWORD');
                $sms_url.= '&mobileno=6' . $customer->tel;
                $sms_url.= '&senderid=INFO';
                $sms_url.= '&languagetype=1';
                $sms_url.= '&message=' . $message;

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $sms_url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                if(curl_error($ch)) {
                    Log::error('SMS_MT | CURL FAIL : ' . curl_error($ch));
                }
                $sms_result = curl_exec($ch);
                curl_close($ch);

                if (empty($sms_result) || (int)$sms_result <= 0){
                    Log::error('SMS_MT | ' . $sms_result . ' | ' . $sms_url);
                } else {
                    $sentCount++;
                }
            }
        }

        Log::info(date('d-m-Y') . " First Time Customer SMS Sent $sentCount");
    }
}
