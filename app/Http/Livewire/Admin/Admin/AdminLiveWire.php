<?php

namespace App\Http\Livewire\Admin\Admin;

use Livewire\Component;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Models\Rank;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class AdminLiveWire extends Component
{
    private $faker;

    public function __construct(Faker $faker)
    {
        $this->faker = $faker;
    }
    public function index()
    {
        $status_users = config('apps.common.status_user');
        $ranks = Rank::all();
        return view('livewire.admin.admins.index', compact('status_users', 'ranks'));
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchData(Request $request)
    {
        $users = User::query()->with(['rank'])->where('role_type', config('apps.common.role_type.admin'));
        return Datatables::of($users)
            ->filter(function ($instance) use ($request) {
                $data = $request->all();

                if (isset($data["status_members"]) &&  count($data["status_members"])) {
                    $instance->whereIn('status_user_id', $data["status_members"]);
                }

                if (isset($data["ranks"]) &&  count($data["ranks"])) {
                    $instance->whereIn('rank_id', $data["ranks"]);
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
            ->addColumn('rank_name', function (User $user) {
                return $user->rank->name;
            })
            ->addColumn('checkbox', function ($item) {
                return '<input role="button" type="checkbox" class="single_checkbox" value="' . $item->id . '" name="user_id[]" />';
            })->addColumn('action', function ($item) {
                return '<a href="' . route('admin.admins.edit', $item->id) . '" class="btn btn-outline-secondary btn-sm edit">
                            <i class="fas fa-pencil-alt"></i>
                        </a>';
            })
            ->make(true);
    }

    public function deleteAdmin(Request $request)
    {
        try {
            $response = [
                'status' => config('apps.common.status.success'),
                'message' => trans('translation.Success'),
            ];
            $data = $request->all();
            if (isset($data['users']) && count($data['users'])) {
                User::whereIn('id', $data['users'])
                ->where('role_type', config('apps.common.role_type.admin'))
                ->delete();
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

    public function changeStatusAdmin(Request $request)
    {
        try {
            $response = [
                'status' =>  config('apps.common.status.success'),
                'message' =>  trans('translation.Success')
            ];
            $data = $request->all();
            if (isset($data['users']) && count($data['users'])) {
                User::whereIn('id', $data['users'])
                    ->where('role_type', config('apps.common.role_type.admin'))
                    ->update(['status_user_id' => $data['status_user']]);
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

    public function edit(Request $request, $id)
    {
        $user = User::where('id', $id)->where('role_type', config('apps.common.role_type.admin'))->first();
        $status_users = config('apps.common.status_user');
        foreach($status_users as $key => $status){
            if((int)$status === (int) $user->status_user_id){
                $user->status_name = trans('translation.'.$key);
            }
       }
        $ranks = Rank::all();
        return view('livewire.admin.admins.edit', compact('status_users', 'ranks', 'user'));
    }

    public function update(UpdateAdminRequest $request, $id)
    {
        try {
            User::where('id', $id)
                ->where('role_type', config('apps.common.role_type.admin'))
                ->update($request
                ->only('nick_name',
                'number_phone',
                'full_name',
                'date_of_joining',
                'rank_id',
                'status_user_id'));
                return redirect()->back()->with('success', trans('translation.Your_work_has_been_saved'));
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', trans('translation.Something_went_wrong'));
        }
    }

    public function create()
    {
        $ranks = Rank::all();
        return view('livewire.admin.admins.create', compact('ranks'));
    }

    public function store(StoreAdminRequest $request)
    {
        try {
            $user = new User();
            $user->nick_name = $request->nick_name;
            $user->full_name = $request->nick_name;
            $user->rank_id = $request->rank_id;
            $user->gender = config('apps.common.genders.Male');
            $user->age = 20;
            $user->date_of_joining = date('Y-m-d');
            $user->status_user_id = 1;
            $user->joining_form_id = 2;
            $user->email = $request->email;
            $user->password = Hash::make( $request->password);
            $user->remember_token = Str::random(20);
            $user->number_phone = $request->number_phone;
            $user->role_type = config('apps.common.role_type.admin');
            $user->nation_id = 2;
            $user->birthday = $this->faker->date('y-m-d');
            $user->save();
            return redirect()->route('admin.admins.index')->with('success', trans('translation.Your_work_has_been_saved'));;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', trans('translation.Something_went_wrong'));;
        }
    }
}
