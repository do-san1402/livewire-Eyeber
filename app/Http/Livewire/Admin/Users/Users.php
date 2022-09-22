<?php

namespace App\Http\Livewire\Admin\Users;

use Livewire\Component;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resource\WalletResouce;
use App\Models\JoiningForm;
use App\Models\Nation;
use App\Models\User;
use App\Models\ProductInventory;
use App\Models\WatchAdvertisementsLog;
use App\Services\Wallets\WalletService;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;

class Users extends Component
{
    public function index()
    {
        $nations = Nation::all();
        $joining_forms = JoiningForm::all();
        $status_users = config('apps.common.status_user');
        $genders = config('apps.common.genders');
        $ages = config('apps.common.ages');
        return view('admin.users.index', compact('nations', 'joining_forms', 'status_users', 'genders', 'ages'));
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchData(Request $request)
    {
        $users = User::query()->with(['nation', 'joining_form'])->where('role_type', config('apps.common.role_type.customer'));
        return Datatables::of($users)
            ->filter(function ($instance) use ($request) {
              
                $data = $request->all();

                if (isset($data["status_members"]) &&  count($data["status_members"])) {
                    $instance->whereIn('status_user_id', $data["status_members"]);
                }
                if (isset($data["genders"]) &&  count($data["genders"])) {
                    $instance->whereIn('gender', $data["genders"]);
                }
                if (isset($data["ages"]) &&  count($data["ages"])) {
                    $instance->whereIn('age', $data["ages"]);
                }
                if (isset($data["nations"]) &&  count($data["nations"])) {
                    $instance->whereIn('nation_id', $data["nations"]);
                }
                if (!empty($request->get('search'))) {
                    $instance->where(function ($w) use ($request) {
                        $search = $request->get('search');
                        $w->orWhere('nick_name', 'LIKE', "%$search%")
                            ->orWhere('full_name', 'LIKE', "%$search%")
                            ->orWhere('email', 'LIKE', "%$search%");
                    });
                }
                $instance->get();
            })->addColumn('status_user_name', function (User $user) {
                $status_users = config('apps.common.status_user');
               foreach($status_users as $key => $status){
                    if((int)$status === (int) $user->status_user_id){
                        return trans('translation.'. $key);
                    }
               }
            })
            ->editColumn('age', function (User $user) {
                return $user->age . trans('translation.Year');
            })
            ->editColumn('gender', function (User $user) {
                if ($user->gender == config('apps.common.genders.Male')) {
                    return trans('translation.Male');
                } else if ($user->gender ==  config('apps.common.genders.Female')) {
                    return trans('translation.Female');
                } else {
                    return trans('translation.Unchecked');
                }
            })
            ->addColumn('nation_name', function (User $user) {
                return $user->nation->name;
            })
            ->addColumn('joining_form_name', function (User $user) {
                return $user->joining_form->name;
            })
            ->addColumn('checkbox', function ($item) {
                return '<input role="button" type="checkbox" class="single_checkbox" value="' . $item->id . '" name="user_id[]" />';
            })->addColumn('action', function ($item) {
                return '<a href="' . route('admin.users.show', $item->id) . '" class="btn btn-outline-secondary btn-sm edit">
                            <i class="fas fa-pencil-alt"></i>
                        </a>';
            })->make(true);
    }

    public function deleteUser(Request $request)
    {
        try {
            $response = [
                'status' => config('apps.common.status.success'),
                'message' => trans('translation.Success'),
            ];
            $data = $request->all();
            if (isset($data['users']) && count($data['users'])) {
                User::whereIn('id', $data['users'])->where('role_type', config('apps.common.role_type.customer'))->delete();
            }
            return  response()->json($response);
        } catch (Exception $e) {
            $response = [
                'status' => config('apps.common.status.fail'),
                'message' => trans('translation.Fail'),
            ];
            Log::error($e->getMessage());

            return  response()->json($response);
        }
    }

    public function changeStatusMember(Request $request)
    {
        try {
            $response = [
                'status' =>  config('apps.common.status.success'),
                'message' =>  trans('translation.Success')
            ];
            $data = $request->all();
            if (isset($data['users']) && count($data['users'])) {
                User::whereIn('id', $data['users'])->where('role_type', config('apps.common.role_type.customer'))->update(['status_user_id' => $data['status_user']]);
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

    public function show($id)
    {
        $user = User::where('id', $id)->where('role_type', config('apps.common.role_type.customer'))->first();
        if ($user) {
            $productInventory = ProductInventory::where('user_id', $user->id)->with('product')->get();
            $status_users = config('apps.common.status_user');
            $nation = Nation::all();
            return view('admin.users.edit', compact('user', 'nation', 'status_users', 'productInventory'));
        } else {
            return view('admin.errors.pages-404');
        }
    }
    public function edit($id, Request $request)
    {
        try {
            $request->validate(
                [
                    'email' => 'email',
                    'full_name' => 'string',
                    'nick_name' => 'string',
                    'birthday' => 'date',
                    'nation' => 'string',
                    'date_of_joining' => 'date',
                    'avatar' => 'image',
                    'location_detail' => 'string',
                ],
            );
            $data = $request->only(
                'nick_name',
                'full_name',
                'status_user_id',
                'gender',
                'nation_id',
                'birthday',
                'email',
                'date_of_joining',
                'location_detail'
            );
            $get_avatar = $request->file('avatar');
            if ($get_avatar) {
                $new_image = 'user_' . $id .  '.' . $get_avatar->getClientOriginalExtension();
                $get_avatar->storeAs('images/avatars', $new_image);
                $data['avatar'] = $new_image;
            }
            if (!empty($data) && !empty($id)) {
                User::where('id', $id)->update($data);
                return redirect()->back()->with('success', trans('translation.Your_work_has_been_saved'));
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', trans('translation.Something_went_wrong'));
        }
        
        
    }

    public function delete_image($id)
    {
        $user = User::find($id);
        if ($user) {
            User::where('id', $id)->whereNotNull('avatar')->update(['avatar' => null]);
        }
        return redirect()->back();
    }

    public function wallet($id)
    {
        $wallet = WalletService::wallet($id);
        if(!count($wallet)){
            return $this->sendResponse([],'Wallet success');
        }

        return $this->sendResponse(new WalletResouce($wallet),'Wallet success');
    }
    
    public function productInventory($id)
    {
        $user = User::find($id);
        $product_inventorys = $user->product_inventory;
        if(!count($product_inventorys)){
            return $this->sendResponse([],'product inventory success');
        }
        $product_inventorys =   $product_inventorys->groupBy('product_id');
        $product_inventory_array = $product_inventorys->map(function ($item, $key) {
            return [
                'numbers' => $item->count(),
                'product_name' =>  $item[0]->product_inventory_name,
            ];
        });

        return $this->sendResponse(array_values($product_inventory_array->toArray()),'product inventory success');
    }

    public function miningStatus(Request $request)
    {
        $watchAdvertisementsLog = WatchAdvertisementsLog::where('user_id', $request->user_id)
        ->where('created_at', 'like',"%$request->date%")->get();

        return $this->sendResponse($watchAdvertisementsLog,'mining status success');
    }
}
