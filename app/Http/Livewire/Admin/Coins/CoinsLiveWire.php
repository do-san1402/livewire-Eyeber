<?php

namespace App\Http\Livewire\Admin\Coins;

use Livewire\Component;
use App\Http\Controllers\Api\BaseController;
use App\Models\Coin;
use App\Models\SettingCommon;
use App\Models\UserWallet;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class CoinsLiveWire extends Component
{
    public $image_default;

    public function __construct() {
       $this->image_default = asset('assets/images/logo-sm.png');
    }

    function index()
    {
        $image_default =  $this->image_default;
        $coins = Coin::all();
        $coin = Coin::find(config('apps.common.coin_id.MATIC'));
        
        return view('livewire.admin.coins.index', compact('image_default', 'coins', 'coin'));
    }

    public function fetchData(Request $request)
    {
        $wallet = UserWallet::query();
        return DataTables::of($wallet)
        ->filter(function ($instance) use ($request) {
            $data = $request->all();
            if (!empty($request->get('search'))) {
                $search = $request->get('search');
                $instance->whereHas('user' ,function($q) use($search){
                    $q->where('nick_name', 'like', "%$search%");
                });
            }
            if(isset($data['coins']) &&  count($data['coins'])){
                $instance->where('coin_id', $data['coins']['coin_id']);
            }
            $instance->get();
        })
        ->addColumn('nick_name', function (UserWallet $user_wallet) {
            if(!empty($user_wallet->user)) {
                return $user_wallet->user->nick_name;
            }
            return '';
        })->addColumn('amount', function (UserWallet $user_wallet) {
            return $user_wallet->amount;
        })->addColumn('wallet_address', function (UserWallet $user_wallet) {
            return $user_wallet->address;
        })->make(true);
    }

    public function detailOrUpdate(Request $request)
    {
       try{
           $coin = Coin::find($request->coin_id);
           if(isset($request->all()['coin_name']) && !empty($request->all()['coin_name'])){
               $validator = Validator::make($request->all(), [
                       'coin_name'     => 'required|string',
                       'coin_id'     => 'required|integer',
                       'coin_symbol_name'     => 'required|regex:/^[A-Z0-9][\[A-Z\-0-9\]]*$/u',
                       'coin_status' => 'required|integer',
                   ],[
                       'coin_symbol_name.regex' => trans('translation.symbol_name_must_be_written_in_capital_letters')
                   ]
               );
               if ($validator->fails()) {
                   return $this->sendError('Validation Error.', $validator->errors(), Response::HTTP_OK);
               }
               $coin->name = $request->coin_name;
               $coin->symbol_name = strtoupper($request->coin_symbol_name);
               if ($request->hasFile('image')) {
                    $digits = 4;
                    $code = rand(pow(10, $digits-1), pow(10, $digits)-1);
                    $get_image = $request->file('image');
                    $new_image          = 'coin_' .$code. '.' . $get_image->getClientOriginalExtension();
                    $get_image->storeAs('storage/images/coins/', $new_image, 'real_public');
               }
               $coin->image = $new_image ??  $coin->image;
               $coin->admin_wallet->status = $request->coin_status;
               $coin->admin_wallet->save();
               $coin->save();
           }
           $admin_wallet = $coin->admin_wallet;
           $user_wallets = $coin->user_wallet;
           $coins = Coin::with('admin_wallet')->get();
           $data = [
               'coin' => $coin,
               'admin_wallet' => $admin_wallet,
               'user_wallets' => $user_wallets,
               'coins' => $coins,
               'position' => $coin->id,
           ];
           $response = [
            'status' =>  config('apps.common.status.success'),
            'message' =>  trans('translation.Success'),
            'data' => $data,
            ];
            return  response()->json($response);
        }catch(Exception $e){
            $response = [
                'status' => config('apps.common.status.fail'),
                'message' => config('apps.common.Fail'),
            ];
            Log::error($e->getMessage());
            return  response()->json($response);
        }
    }

    public function coin_swap_setting() {
        $image_default =  $this->image_default;
        $coin_matic = (int)config('apps.common.coin_id.MATIC');
        $min_key = 'min_'.$coin_matic;
        $min_value = SettingCommon::where('key', $min_key)->first()->value;
        $coins = Coin::all();
        $receive_list = $this->function_receive_list($coin_matic);
        $coin_present= Coin::find($coin_matic);
        return  view('livewire.admin.coins.coin_swap_settings', compact('image_default', 'coins', 'coin_present', 'receive_list', 'min_value'));
    }

    public function detailCoinSwapSetting(Request $request) {
        $coin_id = $request->coin_id;
        $min_key = 'min_'. $coin_id;
        $min_value = SettingCommon::where('key', $min_key)->first()->value;
        $receive_list = $this->function_receive_list($coin_id);
        $data = [
            'min_value'=> $min_value,
            'receive_list' => $receive_list,
            'coin' => Coin::find($coin_id),
        ];
        return $this->sendResponse($data, 'detail success');
    }

    public function updateSwapSetting(Request $request) {
        try{
            DB::beginTransaction();
            $coin_exchange = $request->coin_exchange;
            $coins = Coin::all();
            $coin_receive_ids = $request->coin_receive_ids;
            $data = $request->all();
            $min_key = 'min_' . $coin_exchange;
            $min = SettingCommon::where('key', $min_key)->first();
            $min->value = (float) $request->min;
            $min->save();
    
            $receive_list = [];
    
            foreach($coin_receive_ids as $key => $coin){
              
                $settingCommon = SettingCommon::where('value->coin_exchange', $coin_exchange)
                ->where('value->coin_receive', $request['coin_receive_ids'][$key])->first();
                
                $settingCommonJson = json_decode($settingCommon->value);
                $settingCommonJson->rate = (float)$data['coin_receive_rates'][$key];
                $settingCommon->value = json_encode($settingCommonJson);
                $settingCommon->save();
                $settingCommonReveice = SettingCommon::where('value->coin_exchange', $request['coin_receive_ids'][$key])
                ->where('value->coin_receive', $coin_exchange)->first();
                $settingCommonReveiceJson =  json_decode($settingCommonReveice->value);
                $settingCommonReveiceJson->rate =  1/(float)$data['coin_receive_rates'][$key];
                $settingCommonReveice->value = json_encode($settingCommonReveiceJson);
                $settingCommonReveice->save();
                $receive_list[] = [
                    'rate' => $settingCommonJson->rate,
                    'symbol_name' => Coin::find($request['coin_receive_ids'][$key])->symbol_name,
                    'coin_receive' => $request['coin_receive_ids'][$key]
                ];
            }
            DB::commit(); 
            $data = [
                'min_value'=> $min->value,
                'receive_list' => $receive_list,
                'coin' => Coin::find($coin_exchange),
            ];
            $response = [
                'status' =>  config('apps.common.status.success'),
                'message' =>  trans('translation.Success'),
                'data' => $data,
            ];
            return  response()->json($response);
        }catch(Exception $e){
            $response = [
                'status' => config('apps.common.status.fail'),
                'message' => config('apps.common.Fail'),
            ];
            Log::error($e->getMessage());
            return  response()->json($response);
        }
        
    }
    
    public function function_receive_list($coin_ignore){
        $coins = Coin::all();
        $receive_list = [];
        foreach($coins as $coin){
            if($coin->id == $coin_ignore){
                continue;
            }
            $settingCommon = SettingCommon::where('value->coin_exchange', $coin_ignore)
            ->where('value->coin_receive', $coin->id)->first();
            $settingCommon = json_decode($settingCommon->value);
            $receive_list[] = [
                'rate' => $settingCommon->rate,
                'symbol_name' => $coin->symbol_name,
                'coin_receive' => $coin->id
            ];
        }
        return $receive_list;
    }
}
