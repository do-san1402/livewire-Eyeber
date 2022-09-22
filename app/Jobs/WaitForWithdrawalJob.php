<?php

namespace App\Jobs;

use App\Models\Coin;
use App\Models\CoinLog;
use App\Models\UserWallet;
use App\Models\WalletAddressHistory;
use App\Services\Wallets\WalletService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Exception;
use Illuminate\Support\Facades\Log;

class WaitForWithdrawalJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $coin_log_id_array;
    private $walletService;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $coin_log_id_array,WalletService $walletService)
    {
        $this->coin_log_id_array = $coin_log_id_array;
        $this->walletService = $walletService;
     
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $coinLogs = CoinLog::whereIn('id', $this->coin_log_id_array)->get();
        foreach($coinLogs as $coinLog){
            try{
                $toAddrress = $coinLog->address;
                $wallet = UserWallet::where('user_id', $coinLog->user_id)
                ->where('coin_id', $coinLog->coin_id)
                ->where('status', config('apps.common.status_wallet.activate'))->first();
                $amount = $coinLog->amount;
                if($wallet->amount >= $amount){
                    $walletAddress = WalletAddressHistory::where('user_id', $coinLog->user_id)->latest()->first();
                    if(!$walletAddress){
                        CoinLog::where('id', $coinLog->id)->update(['status_log_coin' => config('apps.common.status_log_coin.withdrawal_failed')]);
                        continue;
                    }
                    $fromAddress = $walletAddress->address;
                    $privateKey = $walletAddress->private_key;
                    $coin =  Coin::find($coinLog->coin_id);
                    $unit = strtolower($coin->symbol_name);
                    $response = $this->walletService->transfer($unit, $fromAddress, $toAddrress, $amount, $privateKey);
                    if( isset($response["status"])  && $response["status"] ){
                        // coinlog update status = withdrawal_success 
                        CoinLog::where('id', $coinLog->id)->update(['status_log_coin' => config('apps.common.status_log_coin.withdrawal_success')]);
                        // reduce wallet of user
                        $wallet->amount =  $wallet->amount - $amount;
                        $wallet->save(); 
                    }else{
                        // coinlog update status = withdrawal_failed 
                        CoinLog::where('id', $coinLog->id)->update(['status_log_coin' => config('apps.common.status_log_coin.withdrawal_failed')]);
                    }

                }
            }catch(Exception $e){
                Log::error($e->getMessage());
                CoinLog::where('id', $coinLog->id)->update(['status_log_coin' => config('apps.common.status_log_coin.withdrawal_failed')]);
            }
        }
       
    }
}
