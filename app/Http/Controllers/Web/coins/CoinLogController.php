<?php

namespace App\Http\Controllers\Web\coins;

use App\Http\Controllers\Api\BaseController;
use App\Jobs\WaitForWithdrawalJob;
use App\Models\Coin;
use App\Models\CoinLog;
use App\Models\WalletAddressHistory;
use App\Services\Wallets\WalletService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;


class CoinLogController extends BaseController
{
    public $image_default;
    private $confirms;
    private $walletService;

    public function __construct(WalletService $walletService) {
       $this->image_default = asset('assets/images/logo-sm.png');
       $this->confirms = [   
            'confirmed'  => 4,
            'no_confirm' => 5,
        ];
        $this->walletService = $walletService;
    }

    function index(Request $request)
    {
        $user_id =  $request->user_id ? $request->user_id : null;
        $status_classification_coins = config('apps.common.status_classification_coin');
        $coins = Coin::all();
        $status_log_coins = config('apps.common.withdrawal_status');
        return view('admin.coins.log', compact('status_classification_coins', 'coins', 'status_log_coins', 'user_id'));
    }

    public function fetchData(Request $request)
    {
        $coinLogs = CoinLog::query();
        return DataTables::of($coinLogs)
        ->filter(function ($instance) use ($request) {
            
            $data = $request->all();
            if (isset($data["status_classification"]) &&  count($data["status_classification"])) {
                $instance->whereIn('status_classification_coin', $data["status_classification"]);
            }
            if (isset($data["coin"]) &&  count($data["coin"])) {
                $instance->whereIn('coin_id', $data["coin"]);
            }
            if (isset($data["withdrawal_status"]) &&  count($data["withdrawal_status"])) {
                $instance->whereIn('status_log_coin', $data["withdrawal_status"]);
            }
            if(isset($data["user_id"])){
                $instance->where('user_id', $data["user_id"]);
            }
            if (!empty($request->get('search'))) {
                $search = $request->get('search');
                $instance->whereHas('user', function ($q) use ($search) {
                    $q->where('nick_name', 'like', "%$search%");
                });
            }
            $instance->get();
        })
        ->addColumn('status_classification_coin', function (CoinLog $coinLog) {
            if($coinLog->status_classification_coin === config('apps.common.status_classification_coin.deposit')){
                return trans('translation.deposit');
            }else{
                return trans('translation.withdrawal');
            }
        })->addColumn('date_start', function (CoinLog $coinLog) {
            return $coinLog->date_start;
        })->addColumn('user_name', function (CoinLog $coinLog) {
            if(!empty($coinLog->user)) {
                return $coinLog->user->nick_name;
            }
            return '';
        })->addColumn('coin_name', function (CoinLog $coinLog) {
            return  $coinLog->coin->name."(". $coinLog->coin->symbol_name.")";
        })->addColumn('amount', function (CoinLog $coinLog) {
            return $coinLog->amount;
        })->addColumn('status_log_coin', function (CoinLog $coinLog) {
            
           $status_log_coins =  config('apps.common.status_log_coin');
            if($coinLog->status_log_coin ===  config('apps.common.status_log_coin.wait_for_confirm')){
                return '<button type="button" class="btn btn-warning" >'.trans('translation.wait_for_confirm').'</button>';
            }
            if($coinLog->status_log_coin ===  config('apps.common.status_log_coin.wait_for_withdrawal')){
                return '<button type="button" class="btn btn-warning" >'.trans('translation.wait_for_withdrawal').'</button>';
            }
            if($coinLog->status_log_coin ===  config('apps.common.status_log_coin.withdrawal_success')){
                return '<button type="button" class="btn btn-success" >'.trans('translation.withdrawal_success').'</button>';
            }
            if($coinLog->status_log_coin ===  config('apps.common.status_log_coin.withdrawal_failed')){
                return '<button type="button" class="btn btn-danger" >'.trans('translation.withdrawal_failed').'</button>';
            }
            if($coinLog->status_log_coin ===  config('apps.common.status_log_coin.confirmed')){
                return '<button type="button" class="btn btn-success" >'.trans('translation.confirmed').'</button>';
            }
            if($coinLog->status_log_coin ===  config('apps.common.status_log_coin.no_confirm')){
                return '<button type="button" class="btn btn-danger" >'.trans('translation.no_confirm').'</button>';
            }
            if($coinLog->status_log_coin ===  config('apps.common.status_log_coin.deposit_success')){
                return '<button type="button" class="btn btn-success" >'.trans('translation.deposit_success').'</button>';
            }
            return '';
        })->addColumn('date_end', function (CoinLog $coinLog) {
            return $coinLog->date_end;
        })->addColumn('txld', function (CoinLog $coinLog) {
            return $coinLog->address;
        })->rawColumns(['status_log_coin','action'])->make(true);
    }

    public function witdrawConfirmList(Request $request) {
        $user_id =  $request->user_id ? $request->user_id : null;
        $status_classification_coins = config('apps.common.status_classification_coin');
        $coins = Coin::all();
        // confirm 
        $confirms =  $this->confirms;
        return view('admin.coins.log_witdraw', compact('status_classification_coins', 'coins', 'confirms', 'user_id'));
    }

    public function fetchDataWitdraw(Request $request) {
        $coinLogs = CoinLog::where('status_classification_coin', config('apps.common.status_classification_coin.withdrawal'))->where('status_log_coin', config('apps.common.status_log_coin.wait_for_confirm'));
        return DataTables::of($coinLogs)
        ->filter(function ($instance) use ($request) {
            
            $data = $request->all();
            if (isset($data["status_classification"]) &&  count($data["status_classification"])) {
                $instance->whereIn('status_classification_coin', $data["status_classification"]);
            }
            if (isset($data["coin"]) &&  count($data["coin"])) {
                $instance->whereIn('coin_id', $data["coin"]);
            }
            if (isset($data["withdrawal_status"]) &&  count($data["withdrawal_status"])) {
                $instance->whereIn('status_log_coin', $data["withdrawal_status"]);
            }
            if(isset($data["user_id"])){
                $instance->where('user_id', $data["user_id"]);
            }
            if (!empty($request->get('search'))) {
                $search = $request->get('search');
                $instance->whereHas('user', function ($q) use ($search) {
                    $q->where('nick_name', 'like', "%$search%");
                });
            }
            $instance->get();
        })
        ->addColumn('status_classification_coin', function (CoinLog $coinLog) {
            if($coinLog->status_classification_coin === config('apps.common.status_classification_coin.deposit')){
                return trans('translation.deposit');
            }else{
                return trans('translation.withdrawal');
            }
        })->addColumn('date_start', function (CoinLog $coinLog) {
            return $coinLog->date_start;
        })->addColumn('user_name', function (CoinLog $coinLog) {
            if(!empty($coinLog->user)) {
                return $coinLog->user->nick_name;
            }
            return '';
        })->addColumn('coin_name', function (CoinLog $coinLog) {
            return  $coinLog->coin->name."(". $coinLog->coin->symbol_name.")";
        })->addColumn('amount', function (CoinLog $coinLog) {
            return $coinLog->amount;
        })->addColumn('date_end', function (CoinLog $coinLog) {
            return $coinLog->date_end;
        })->addColumn('txld', function (CoinLog $coinLog) {
            return $coinLog->address;
        })->addColumn('checkbox', function ($item) {
            return '<input role="button" type="checkbox" class="single_checkbox" value="' . $item->id . '" name="coin_log[]" />';
        })->addColumn('action', function (CoinLog $coinLog) {
            return '<button type="button" class="btn btn-warning" onclick="confirm_only_one(this.id)"  id="'.$coinLog->id.'" data-bs-toggle="modal" data-bs-target="#modal_change_status_advertisement">'.trans('translation.wait_for_confirm').'</button>';
        })->make(true);
    }

    public function witdrawConfirm(Request $request)
    {
        try {
            $data = $request->all();
            $response = [
                'status' =>  config('apps.common.status.success'),
                'message' =>  trans('translation.Success')
            ];
            if(isset($data['coinLogId']) && $data['coinLogId']){
                if((int)$data['status'] === (int) config('apps.common.status_log_coin.confirmed')){
                    CoinLog::where('id', $data['coinLogId'])->update(['status_log_coin' => config('apps.common.status_log_coin.wait_for_withdrawal')]);
                    $coin_log_id_array = [];
                    $coin_log_id_array[] = $data['coinLogId'];
                    WaitForWithdrawalJob::dispatch($coin_log_id_array,$this->walletService);
                }else{
                    CoinLog::where('id', $data['coinLogId'])->update(['status_log_coin' => $data['status']]);
                }
                return  response()->json($response);
            }
            if((int)$data['status'] === (int) config('apps.common.status_log_coin.confirmed')){
                if (isset($data['coinLog']) && count($data['coinLog'])) {
                    CoinLog::whereIn('id', $data['coinLog'])->update(['status_log_coin' => config('apps.common.status_log_coin.wait_for_withdrawal')]);
                    $coin_log_id_array = $data['coinLog'];
                    WaitForWithdrawalJob::dispatch($coin_log_id_array,$this->walletService);
                }
            }else{
                if (isset($data['coinLog']) && count($data['coinLog'])) {
                    CoinLog::whereIn('id', $data['coinLog'])->update(['status_log_coin' => $data['status']]);
                }
            }
            return  response()->json($response);
        } catch (Exception $e) {
            $response = [
                'status' => config('apps.common.status.fail'),
                'message' => config('apps.common.Fail'),
            ];
            Log::error($e->getMessage());
            return  response()->json($response);
        }
    }

}
