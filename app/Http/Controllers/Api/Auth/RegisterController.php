<?php

namespace App\Http\Controllers\Api\Auth;


use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Api\RegisterRequest;
use App\Models\EmailVerification;
use App\Models\User;
use App\Models\WalletAddressHistory;
use App\Services\PostManService;
use App\Services\Wallets\WalletService;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class RegisterController extends BaseController
{

    private $walletService;
    private $provider_type;

    public function __construct(WalletService $walletService)
    {
        $this->WalletService = $walletService;    
        $this->provider_type = config('apps.common.provider_type');
    }
    /**
     * Handle register member.
     *
     * @return \Illuminate\Http\Response
     */
    public function register(RegisterRequest $request)
    {
        try{
            $email_verification = EmailVerification::where('email', $request->email)->first();
            if(!$email_verification){
                return $this->sendError("Your email isn't there yet", 
                ['error' => trans('translation.Your_email_isnt_there_yet')]);
            }
                     
            if( (int)$email_verification->status === (int)config('apps.common.status.success') ){
                DB::beginTransaction();
                $user = new User();
                $user->nick_name = $request->nick_name;
                $user->full_name = $request->full_name;
                $user->nation_id = $request->nation_id;
                $user->rank_id = 1; // integration
                $user->birthday = $request->birthday;
                $user->status_user_id = 2; // acknowledgement
                $user->joining_form_id = 1;// normally
                $user->password = Hash::make($request->password);
                $user->location_detail = $request->location_detail;
                $user->gender = $request->gender;
                $user->date_of_joining = date('y-m-d');
                $user->email =  $request->email;
                $user->remember_token = Str::random(20);
                $user->role_type =  config('apps.common.role_type.customer');
                $user->save();

                // create address and private_key for user 
                $header = [
                    'accept' => 'application/json',
                    'Content-Type' => 'application/json'
                ];
                $endPoint = '/api/wallet';
                $dataPost = [
                    'providerType' => $this->provider_type
                ];
                $wallet = $this->WalletService->post($header, $endPoint, $dataPost);
                if( isset($wallet['address']) && $wallet['address']  && isset($wallet['privateKey']) && $wallet['privateKey'] ){
                    $addressWallet = new WalletAddressHistory();
                    $addressWallet->user_id = $user->id;
                    $addressWallet->address = $wallet['address'];
                    $addressWallet->private_key = $wallet['privateKey'];
                    $addressWallet->save();
                }else{
                    return $this->sendError("Create wallet fail", 
                    ['error' => trans('translation.Create_wallet_fail')]);
                }
               
                DB::commit();
                $data = [];
                $data['user'] = $user;
                $data['addressWallet'] = $addressWallet;
                return  $this->sendResponse( $data, 'Register success');
            } else {
                return $this->sendError("Your email isn't there yet", 
                ['error' => trans('translation.Your_email_isnt_there_yet')]);
            }
        }catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return $this->sendError("Register fail", 
            ['error' => trans('translation.Register_fail')]);
        }
       
       
    }

    public function email_verification(Request $request)
    {
        $this->validate($request,[
            'email'     => 'required|email|string',
        ]);
        $digits = 4;
        $code = rand(pow(10, $digits-1), pow(10, $digits)-1);
        PostManService::sendEmailGetCode('api.email.send_email_get_code', $request->email, trans('translation.Please_verify_your_email'), $code );
        $email_verification = EmailVerification::where('email', $request->email)->first();
        if(!$email_verification)
        {
            $email_verification = new EmailVerification();
            $email_verification->email = $request->email;
            $email_verification->code = $code;
            $email_verification->save();
            return $this->sendResponse('', 'Sent you an authentication code');
        }else{
            $email_verification->code = $code;
            $email_verification->created_at = date("Y-m-d H:i:s");
            $email_verification->status = config('apps.common.status.fail');
            $email_verification->save();
            return $this->sendResponse('', 'Sent you an authentication code');
        }
    }

    public function confirm_email(Request $request)
    {
        $this->validate($request,[
            'email'     => 'required|email|string',
        ]);
        $email_verification = EmailVerification::where('email',$request->email)->first();
        if(!$email_verification){
            return $this->sendError("Your email isn't there yet", 
            ['error' => trans('translation.Your_email_isnt_there_yet')]);
        }
        $time_current = new DateTime(date("Y-m-d H:i:s")); // time current
        $time_email_verifi = strtotime($email_verification->created_at)+(60*5);
        $time_email_verifi = date("Y-m-d H:i:s", $time_email_verifi);
        $time_email_verifi = new DateTime($time_email_verifi);
       
        if($time_email_verifi >= $time_current ){
            if( (int)$request->code === (int)$email_verification->code ){
                $email_verification->status = config('apps.common.status.success');
                $email_verification->save();
                return $this->sendResponse('', 'Successful authentication');
            }else{
                return $this->sendError("Incorrect authentication code", 
                ['error' => trans('translation.Incorrect_authentication_code')]);
            }
        }else{
            return $this->sendError("Email authentication time has expired", 
            ['error' => trans('translation.Email_authentication_time_has_expired')]);
        }
    }
}
