<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resource\UserCollection;
use App\Http\Resource\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends BaseController
{
    public function update(Request $request)
    {
        $this->validate($request,[
            'nick_name' => 'required|string',
            'full_name'  => 'required|string',
            'birthday' => 'required|date'
        ]);
        try{
            $user = Auth::user();
            $id = $user->id;
            $user = User::find($id);
            $user->nick_name = $request->nick_name;
            $user->full_name = $request->full_name;
            $user->birthday = $request->birthday;
            $user->save();
            return $this->sendResponse($user, 'Edit success');
        }catch(Exception $e){
            Log::error($e->getMessage());
            return $this->sendError('Edit fail.', ['error' => trans('traslation.Edit_fail')]);
        }
        
    }

    public function find_account(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'full_name' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $success['email'] = $user->email;
            $success['full_name'] = $user->full_name;
            return $this->sendResponse($success, 'Find account successfully.');
        }
        else {
            return $this->sendError('Does not exist.', ['error' => 'Does not exist']);
        }
    }

    public function secession(Request $request)
    {
        $this->validate($request,[
            'password' => 'required|string',
        ]);
        $userAuth = Auth::user();
        if (Hash::check($request->password, $userAuth->password)) {
            try{
                $id = $userAuth->id;
                $user = User::find($id);
                $user->status_user_id = config('apps.common.status_user.secession');//탈퇴 = secession
                $user->save();
                $userAuth->tokens()->delete();
                return $this->sendResponse('', 'Secession success');
            }catch(Exception $e){
                Log::error($e->getMessage());

                return $this->sendError('Secession_fail', ['error' => trans('translation.Secession_fail')]);
            }
        }else{

            return $this->sendError('Your password is incorrect', ['error' => trans('translation.your_password_is_incorrect')]);
        }       
    }

    public function profile()
    {
        $user = Auth::user();
        return $this->sendResponse(new UserResource($user), 'Information account');
    }
          
    public function updatePassword(Request $request)
    {
        $this->validate($request,[
            'password_current' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
        ]);
        $user = Auth::user();
        if (Hash::check($request->password_current , $user->password)) {
            $id = $user->id;
            $user = User::find($id);
            $user->password = Hash::make($request->password);
            $user->save();
            return $this->sendResponse('', 'Update password successfully.');
        } else {
            return $this->sendError("Your password is incorrect",
                ['error' => trans('translation.your_password_is_incorrect')]
            );
        }
    }

    public function upload_image(Request $request)
    {
        $validator = Validator::make($request->all(),[ 
            'avatar' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
        ]);   
    
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if(!$request->hasFile('avatar')) {
            return $this->sendError("Upload file fail",
            ['error' => trans('translation.upload_file_fail')]
        );
        }

        $get_avatar = $request->file('avatar');
        if ($get_avatar) {
            $new_image = 'user_' . time() .  '.' . $get_avatar->getClientOriginalExtension();
            $get_avatar->storeAs('images/avatars', $new_image);
        }
        $user = Auth::user();
        $user = User::find($user->id);
        $user->avatar = $new_image;
        $user->save();
        return $this->sendResponse(new UserResource($user), 'Upload image success');
    }

    public function search(Request $request)
    {
        $search =  $request->search;
        $user = User::orWhere('nick_name', 'LIKE', "%$search%")
        ->orWhere('full_name', 'LIKE', "%$search%")
        ->orWhere('email', 'LIKE', "%$search%")->get();
        return $this->sendResponse(new UserCollection($user), 'search user success');
    }

    public function saveDeviceToken(Request $request)
    {
        $check = Validator::make($request->all(), [
            'fcm_token' => 'required|string',
        ]);
        $user = Auth::user();
        $user = User::find($user->id);
        if ($check->fails()) {
            return $this->sendError('Validation Error.', $check->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $user->device_token = $request->fcm_token;
        $user->save();

        return $this->sendResponse($user, 'update device token success');
    }
}
