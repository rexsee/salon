<?php

namespace App\Console\Commands;

use App\Models\Customer;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckBirthday extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:birthday';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send SMS to birthday customer';

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
        $customers = Customer::where('dob','like','%-' . date('m') . '-%')->get();
        foreach ($customers as $customer) {
            if(!empty(env('SMS_USERNAME')) && !empty(env('SMS_MT_URL'))){
                $message = urlencode('Happy Birthday! We will love to treat you a 20% off from all our chemical services. All you have to do is just PM ' . env('APP_NAME') . ' or ring us at 0327338402.');
//                $message = urlencode('Happy Birthday ' . $customer->name . '. Warmest birthday wishes from ' . env('APP_NAME') . '. Check our website for special offer for you.');

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
                    telegram_send_message('Birthday alert fail to send SMS :: ' . curl_error($ch));
                }
                $sms_result = curl_exec($ch);
                curl_close($ch);

                if (empty($sms_result) || (int)$sms_result <= 0){
                    Log::error('SMS_MT | ' . $sms_result . ' | ' . $sms_url);
                }
            }
        }
    }
}
