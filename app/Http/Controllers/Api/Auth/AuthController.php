<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\EmailVerification;
use App\Models\JoiningForm;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Socialite;
use Faker\Generator as Faker;
use Exception;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Str;

class AuthController extends BaseController
{
    /**
     * Handle a login request to the api.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            if((int)$user->status_user_id === (int)config('apps.common.status_user.secession')){
                $user->tokens()->delete();
                return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
            }
            $success['token'] = $user->createToken($user->nick_name)->plainTextToken;
            $success['user'] = $user;

            return $this->sendResponse($success, 'User login successfully.');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }

    /**
     * Handle a refresh token user to the api.
     *
     * @return \Illuminate\Http\Response
     */
    public function refresh(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();

        $success['token'] = $user->createToken($user->nick_name)->plainTextToken;
        return $this->sendResponse($success, 'Refresh token successfully.');
    }

    public function change_password(Request $request)
    { 
        
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password_current' => 'required',
                'password' => 'required|confirmed',
                'password_confirmation' => 'required',
                'full_name' => 'required',
            ]);
            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            $email_verification = EmailVerification::where('email', $request->email)->first();
            if (!$email_verification) {
                return $this->sendError(
                    "Your email isn't there yet",
                    ['error' => trans('translation.Your_email_isnt_there_yet')]
                );
            }
            if ((int)$email_verification->status === (int)config('apps.common.status.success')) {
                $user =  User::where('email', $request->email)->first();
                if (Hash::check($request->password_current , $user->password)) {
                    $user->update(['password' => Hash::make($request->password)]);
                    $success['user'] = $user;
                    return $this->sendResponse($success, 'User resets password  successfully.');
                } else {
                    return $this->sendError(
                        "The specified password does not match the database password",
                        ['error' => trans('translation.The_specified_password_does_not_match_the_database_password')]
                    );
                }
            } else {
                return $this->sendError(
                    "Your email has not been confirmed",
                    ['error' => trans('translation.Your_email_has_not_been_confirmed')]
                );
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->sendError(
                "Resest password fail",
                ['error' => trans('translation.Resest_password_fail')]
            );
        }
        
    }

    public function logout()
    {
        $user = Auth::user();
        $user->tokens()->delete();
        return $this->sendResponse('', 'Log out success.');
    }

    /**
     * Redirect the user to the Provider authentication page.
     *
     * @param $provider
     * @return JsonResponse
     */
    public function redirectToProvider($provider)
    {
       
        $validated = $this->validateProvider($provider);
    
        if (!is_null($validated)) {
            return $validated;
        }

        return Socialite::driver($provider)->stateless()->redirect();
    }

    /**
     * Obtain the user information from Provider.
     *
     * @param $provider
     * @return JsonResponse
     */
    public function handleProviderCallback($provider,Faker $faker)
    {
        $validated = $this->validateProvider($provider);
        if (!is_null($validated)) {
            return $validated;
        }
        try {
            $user_provider = Socialite::driver($provider)->stateless()->user();
        } catch (ClientException $exception) {
            return response()->json(['error' => 'Invalid credentials provided.'], 422);
        }
        $join_form = JoiningForm::where('name', $provider)->first();
        if(!$join_form){
            $join_form =  new JoiningForm();
            $join_form->name =  $provider;
            $join_form->save();
        }

        $user =  User::where('email', $user_provider->getEmail())->first();
        if(!$user){
            $user = new User();
            $user->nick_name = $user_provider->getName();
            $user->full_name = $user_provider->getName();
            $user->nation_id = 3;
            $user->avatar =  $user_provider->getAvatar();
            $user->rank_id = 1; // integration
            $user->birthday = $faker->date('y-m-d');
            $user->status_user_id = 2; // acknowledgement
            $user->joining_form_id = $join_form->id;// normally
            $user->password = Hash::make( $faker->password);
            $user->gender = config('apps.common.genders.Male');
            $user->date_of_joining = date('y-m-d');
            $user->email =  $user_provider->getEmail();
            $user->remember_token = Str::random(20);
            $user->save();    
        }
        $success['token'] = $user->createToken($user->nick_name)->plainTextToken;
        $success['user'] = $user;
        return $this->sendResponse($success, 'User login successfully.');
    }

    /**
     * @param $provider
     * @return JsonResponse
     */
    protected function validateProvider($provider)
    {
        if (!in_array($provider, ['facebook', 'github', 'google'])) {
            return response()->json(['error' => 'Please login using facebook, github or google'], 422);
        }
    }
}
