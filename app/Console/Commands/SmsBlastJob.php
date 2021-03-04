<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class SmsBlastJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:work';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Blasting SMS';

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
        if(!empty(env('SMS_USERNAME'))){
            $blast_list_raw = Redis::keys('sms_blast||*');
            if (!empty($blast_list_raw)) {
                $key = $blast_list_raw[0];

                $tels = Redis::command('SPOP',[$key, 10]);
                foreach ($tels as $tel) {
                    $tel_arr = explode('||',$tel);
                    if($tel_arr[2] >= 3) {
                        Redis::command('SADD', ['sms_blast_fail', $tel]);
                    }
                    else {
                        $sms_url = env('SMS_MT_URL') . '?';
                        $sms_url.= 'apiusername=' . env('SMS_USERNAME');
                        $sms_url.= '&apipassword=' . env('SMS_PASSWORD');
                        $sms_url.= '&mobileno=6' . $tel_arr[0];
                        $sms_url.= '&senderid=INFO';
                        $sms_url.= '&languagetype=1';
                        $sms_url.= '&message=' . urlencode("RM0.00 ALPH STUDIO: " . $tel_arr[1]);

                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $sms_url);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                        if(curl_error($ch)) {
                            $this->info('SMS Blast fail to send SMS :: ' . curl_error($ch));
                        }
                        $sms_result = curl_exec($ch);
                        curl_close($ch);

                        if (empty($sms_result) || (int)$sms_result <= 0 ){
                            Log::error('SMS_MT | ' . $sms_result . ' | ' . $sms_url);
                            Redis::command('SADD', [$key, $tel_arr[0] . '||' . $tel_arr[1] . '||' . ($tel_arr[2] + 1)]);
                        }
                    }
                }
            }
        }
    }
}
