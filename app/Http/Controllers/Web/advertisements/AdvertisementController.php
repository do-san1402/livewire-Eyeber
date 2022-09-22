<?php

namespace App\Http\Controllers\Web\advertisements;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\ProductInventory;
use App\Models\WatchAdvertisementsLog;
use App\Models\Nation;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\admin\AdvertisementRequest;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Spatie\LaravelIgnition\Recorders\DumpRecorder\Dump;

class AdvertisementController extends Controller
{


    public function index()
    {
        $ads_stautus  = config('apps.common.ads_status');
        return view('admin.advertisements.index', compact('ads_stautus'));
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchData(Request $request)
    {
        $users = Advertisement::query();
        return Datatables::of($users)

            ->filter(function ($instance) use ($request) {
                $data = $request->all();

                if (isset($data["ads_status_id"]) &&  count($data["ads_status_id"])) {
                    $instance->whereIn('ad_status_id', $data["ads_status_id"]);
                }

                if (!empty($request->get('search'))) {
                    $instance->where(function ($w) use ($request) {
                        $search = $request->get('search');
                        $w->Where('name', 'LIKE', "%$search%");
                        $ads_status = config('apps.common.ads_status');
                        $status = '';
                        foreach ($ads_status as $key => $ad) {
                            if (strtolower($search) == strtolower(str_replace('_', ' ', $key)) || strtolower($search) == strtolower(trans('translation.' . $key))) {
                                $status = $ad;
                            }
                        }
                        if ($status !== '') {
                            $w->orWhere('ad_status_id', $status);
                        }
                    });
                }
                $instance->get();
            })->addColumn('ad_status_name', function (Advertisement $advertisement) {
                if ($advertisement->ad_status_id === config('apps.common.ads_status.hide')) {
                    return trans('translation.hide');
                } else {
                    return trans('translation.show');
                }
            })->editColumn('rewards', function (Advertisement $advertisement) {
                return number_format($advertisement->rewards) . ' ' . trans('translation.BST');
            })->editColumn('views', function (Advertisement $advertisement) {
                return number_format($advertisement->views);
            })->addColumn('checkbox', function ($item) {
                return '<input role="button" type="checkbox" class="single_checkbox" value="' . $item->id . '" name="advertisement_id[]" />';
            })->addColumn('action', function ($item) {
                return '<a href="' . route('admin.advertisements.edit', $item->id) . '" class="btn btn-outline-secondary btn-sm edit">
                            <i class="fas fa-pencil-alt"></i>
                        </a>';
            })->make(true);
    }

    public function delete(Request $request)
    {
        try {
            $response = [
                'status' => config('apps.common.status.success'),
                'message' => trans('translation.Success'),
            ];
            $data = $request->all();

            if (isset($data['advertisements']) && count($data['advertisements'])) {
                Advertisement::whereIn('id', $data['advertisements'])->delete();
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

    public function changeStatus(Request $request)
    {

        try {
            $response = [
                'status' =>  config('apps.common.status.success'),
                'message' =>  trans('translation.Success')
            ];
            $data = $request->all();
            if (isset($data['advertisements']) && count($data['advertisements'])) {
                Advertisement::whereIn('id', $data['advertisements'])->update(['ad_status_id' => $data['status']]);
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

    public function monitoring()
    {
        $advertisements = Advertisement::orderBy('views', 'desc')->limit(10)->get();
        $view_max = $advertisements[0]->id;
        return view('admin.advertisements.monitoring', compact('advertisements', 'view_max'));
    }

    public function MiningAmountRanking()
    {
        return view('admin.advertisements.miningAmountRanking');
    }

    public function create()
    {
        $nation = Nation::all();
        return view('admin.advertisements.create', compact('nation'));
    }
    public function register_ads(AdvertisementRequest $request)
    {
        try {
            $data = $request->all();
            if ($request->hasFile('video')) {
                $get_video = $request->file('video');
                $new_video = 'advertisements_' . time() .  '.' . $get_video->getClientOriginalExtension();
                $get_video->storeAs('video/advertisements', $new_video);
            }

            $rewards = config('apps.common.mining_settings_auto');
            if ($data['mining_settings'] == config('apps.common.mining_settings.direct')) {
                $rewards = $data['advertisement_setting'];
            }
            $advertisement = new Advertisement;
            if ((int)$data['ad_nation_id'] === 0) {
                $nation = Nation::pluck('id');
                $data['nation_id'] = json_encode($nation);
            } else {
                $data['nation_id'] = json_encode($data['ad_nation_id']);
            }
            $advertisement->name = $data['advertisement_name'];
            $advertisement->description = $data['description'];
            $advertisement->date_end = $data['date_end'];
            $advertisement->date = $data['date_start'];
            $advertisement->date_end = $data['date_end'];
            $advertisement->date_start = $data['date_start'];
            $advertisement->mining_settings = $data['mining_settings'];
            $advertisement->set_collection_deduction = $data['set_collection_deduction'];
            $advertisement->nation_id = $data['nation_id'];
            $advertisement->video = $new_video;
            $advertisement->views = config('apps.common.advertisement.views');
            $advertisement->rewards = $rewards;
            $advertisement->ad_status_id = config('apps.common.advertisement.ad_status_id');
            $advertisement->time = $request->time;
            $advertisement->save();
            return redirect()->route('admin.advertisements.index')->with('success', trans('translation.Your_work_has_been_saved'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', trans('translation.Something_went_wrong'));
        }
    }
    public function audit()
    {
        return view('admin.advertisements.audit');
    }
    public function edit($id)
    {
        $advertisement = Advertisement::where('id', $id)->first();
        if ($advertisement) {
            $nation_id = $advertisement->nation_id;
            $nation = Nation::select('name', 'id')->get();
            $advertisement_setting = '';
            if ($advertisement->mining_settings == config(('apps.common.mining_settings.direct'))) {
                $advertisement_setting = $advertisement->rewards;
            }
            $count_number_ads = WatchAdvertisementsLog::groupBy('user_id')->count();
            $count_product_ads = WatchAdvertisementsLog::groupBy('product_inventory_id')->count();

            return view('admin.advertisements.edit', compact('advertisement', 'advertisement_setting', 'nation_id', 'nation', 'count_number_ads', 'count_product_ads'));
        } else {
            return view('admin.errors.pages-404');
        }
    }

    public function delete_video($id)
    {
        $user = Advertisement::find($id);
        if ($user) {
            Advertisement::where('id', $id)->whereNotNull('video')->update(['video' => null]);
        }
        return redirect()->back();
    }
    public function update($id, AdvertisementRequest $request)
    {
        try {
            $data = $request->only(
                'description',
                'mining_settings',
                'set_collection_deduction',
                'date_start',
                'date_end',
                'ad_status_id',
            );
            $data['time'] = $request->time ? $request->time : Advertisement::find($id)->time;
            if ($data['mining_settings'] == config('apps.common.mining_settings.auto')) {
                $data['rewards'] = config('apps.common.mining_settings_auto');
            } else {
                $data['rewards'] = $request->advertisement_setting;
            }
            $data['name'] = $request->advertisement_name;
            if ($request->hasFile('video')) {
                $get_video = $request->file('video');
                $new_video = 'advertisements_' . time() .  '.' . $get_video->getClientOriginalExtension();
                $get_video->storeAs('video/advertisements', $new_video);
                $data['video'] = $new_video;
            }
            if ((int)$request->ad_nation_id === 0) {
                $nation = Nation::pluck('id');
                $data['nation_id'] = json_encode($nation);
            } else {
                $data['nation_id'] = json_encode($request->ad_nation_id);
            }
    
            if (!empty($data) && !empty($id)) {
                Advertisement::where('id', $id)->update($data);
                return redirect()->back()->with('success', trans('translation.Your_work_has_been_saved'));;
            }
            
        } catch (Exception $e) {
            return redirect()->back()->with('error', trans('translation.Something_went_wrong'));
        }
        
    }

    public function upload_video(Request $request)
    {
        $get_video = $request->file('video');

        $new_video = '';
        if ($request->hasFile('video')) {
            if ($get_video->getClientMimeType() == "video/mp4") {
                $get_video = $request->file('video');
                $new_video = 'advertisements_' . time() .  '.' . $get_video->getClientOriginalExtension();
                $get_video->storeAs('video/advertisements', $new_video);
            } else {
                $response = [
                    'error' =>   'Not a video format image',
                    'message' => trans('translaiton.Error'),
                ];
            }
        }
        if (isset($request->all()['id'])) {
            Advertisement::where('id', $request->all()['id'])
                ->update(['video'  => $new_video]);
        }
        $response = [
            'video' =>  $new_video ? url('storage/video/advertisements/' . $new_video) : '',
            'textVideo' => $new_video,
            'message' => trans('translaiton.Success'),
        ];
        return response()->json($response);
    }

    public function ads_statistics(Request $request)
    {
        $advertisement_id = $request->id_advertisement;
        $watchAdvertisementsLog = new WatchAdvertisementsLog();
        $watchAdvertisementsLog = $watchAdvertisementsLog->where('advertisement_id', $advertisement_id);
        if ($request->date_start != '' && $request->date_end != '') {
            $watchAdvertisementsLog = $watchAdvertisementsLog
                ->whereBetween('created_at', array($request->date_start, $request->date_end));
        } else {
            $date = isset($request->date) ? $request->date : 1;
            if ($date == 1) {
                $dt = Carbon::now();
                $watchAdvertisementsLog = $watchAdvertisementsLog
                ->whereBetween('created_at', [$dt->startOfDay() , Carbon::now()]);
                
            } else {
                $dateE = Carbon::today()->subDays($date);
                $watchAdvertisementsLog = $watchAdvertisementsLog->whereBetween('created_at', [$dateE, Carbon::now()]);
            }
            $watchAdvertisementsLog = $watchAdvertisementsLog->orderBy('created_at', 'ASC')->get()
                ->groupBy(function($item){
                    return date('H',strtotime($item->created_at));
                })
                ->map(function ($item) {
                    return [
                        'date' => date_format($item[0]->created_at, 'H').trans('translation.Hour'),
                        'time' => $item->sum('time'),
                        'view' => $item->sum('view'),
                        'mining' => $item->sum('cumulative_mining'),
                    ];
                });
                $item_ads =  $watchAdvertisementsLog;
                $view = $watchAdvertisementsLog->sum('view');
                $time =  number_format($watchAdvertisementsLog->sum('time')/60, 2, ',', ' ');
                $response = [
                    'item_ads' => $item_ads,
                    'view' =>  $view,
                    'time' =>  $time,
                ];
            return  response()->json($response);

        }
        $watchAdvertisementsLog = $watchAdvertisementsLog->orderBy('created_at', 'asc')->get()
            ->groupBy(function ($item) {
                return $item->created_at->format('Y-m-d');
            })
            ->map(function ($item) {
                return [
                    'date' => date_format($item[0]->created_at, 'Y-m-d'),
                    'time' => $item->sum('time'),
                    'view' => $item->sum('view'),
                    'mining' => $item->sum('cumulative_mining'),
                ];
            });

        $item_ads =  $watchAdvertisementsLog;
        $view = $watchAdvertisementsLog->sum('view');
        $time =  number_format($watchAdvertisementsLog->sum('time')/60, 2, ',', ' ');
        $response = [
            'item_ads' => $item_ads,
            'view' =>  $view,
            'time' =>  $time,
        ];
        return  response()->json($response);
    }

    public function fetch_table_mining(Request $request)
    {
        $advertisement_id = $request->id_advertisement;
        $watchAdvertisementsLog = WatchAdvertisementsLog::where('advertisement_id', $advertisement_id)
        ->with('product_inventory')
        ->orderBy('view', 'DESC');

        return Datatables::of($watchAdvertisementsLog)
            ->filter(function ($instance) use ($request) {
                $data = $request->all();
                if( $data['date_start'] && $data['date_end']){
                    $instance->whereBetween('created_at', [$data['date_start'], $data['date_end']]);
                }
                $date  = isset($data['dates']) ? $data['dates']['date'] : 1; 
                if($date) {
                    $instance->whereBetween('created_at', [ Carbon::now()->subDay($date), Carbon::now() ] );
                }else {
                    $instance->whereBetween('created_at', [Carbon::now()->subDay($data['dates']['date']), Carbon::now()]);
                }
                if($request->limit){ 
                    $instance->limit((int)$request->limit);
                }
            $instance->get();
            })
            ->addIndexColumn()
            ->addColumn('viewTimes', function ($watchAdvertisementsLog) {
                return $watchAdvertisementsLog->view . ' / ' . $watchAdvertisementsLog->time . ' ' . trans('translation.Episode');
            })
            ->addColumn('name', function (WatchAdvertisementsLog $watchAdvertisementsLog) {
                if(!empty($watchAdvertisementsLog->product_inventory)) {
                    return $watchAdvertisementsLog->product_inventory->product->name;
                }
            })
            ->addColumn('user_id_name', function (WatchAdvertisementsLog $watchAdvertisementsLog) {
                if(!empty($watchAdvertisementsLog->product_inventory)) {
                    return  $watchAdvertisementsLog->user_id . $watchAdvertisementsLog->product_inventory->product->name;
                }
            })
            ->addColumn('mining_rewards', function (WatchAdvertisementsLog $watchAdvertisementsLog) {
                return number_format($watchAdvertisementsLog->cumulative_mining) . ' ' . trans('translation.BST');
            })
        ->make(true);
    }
    
    public function datatable_ads()
    {
        $today = Carbon::now()->toDateTimeString();
        $subday = Carbon::now()->subDays(10)->toDateTimeString();
        $data = WatchAdvertisementsLog::whereBetween('created_at', [$subday, $today])->with('advertisement')->get()
            ->groupBy(function ($date) {
                $created_at = Carbon::parse($date->created_at)->format('Y-m-d');
                return [
                    $created_at . $date['advertisement_id'],
                ];
            })
            ->map(function ($q) {
                return [
                    'item' => $q,
                    'advertisement_id' => $q[0]['advertisement_id'],
                    'cumulative_mining' => $q->sum('cumulative_mining'),
                ];
            })->sortByDesc('cumulative_mining')->take(10);

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('fulldate', function ($data) {
                $advertisement = Advertisement::find($data['advertisement_id']);
                if ($advertisement) {
                    return  $advertisement->date_start . ' ~ ' . $advertisement->date_end;
                }
            })
            ->addColumn('participants', function ($data) {
                return count($data['item']);
            })
            ->addColumn('name', function ($data) {
                $advertisement = Advertisement::find($data['advertisement_id']);
                if ($advertisement) {
                    return  $advertisement->name;
                }
            })
            ->make(true);
    }

    public function fetchDataMonitor()
    {

        $data = WatchAdvertisementsLog::with('advertisement')->get()
            ->groupBy(function ($date) {
                $created_at = Carbon::parse($date->created_at)->format('Y-m-d');
                return [
                    $created_at . $date['advertisement_id'],
                ];
            })
            ->map(function ($q) {
                return [
                    'item' => $q,
                    'advertisement_id' => $q[0]['advertisement_id'],
                    'cumulative_mining' => $q->sum('cumulative_mining'),
                ];
            });

        return Datatables::of($data)
            ->addIndexColumn()

            ->addColumn('fulldate', function ($data) {
                $advertisement = Advertisement::find($data['advertisement_id']);
                if ($advertisement) {
                    return  $advertisement->date_start . ' ~ ' . $advertisement->date_end;
                }
            })
            ->addColumn('participants', function ($data) {
                return count($data['item']);
            })
            ->addColumn('name', function ($data) {
                $advertisement = Advertisement::find($data['advertisement_id']);
                if ($advertisement) {
                    return  $advertisement->name;
                }
            })
            ->addColumn('views', function ($data) {
                $advertisement = Advertisement::find($data['advertisement_id']);
                if ($advertisement) {
                    return  $advertisement->views;
                }
            })
            ->make(true);
    }

    public function fetch_data_chart(Request $request)
    {
        $id_ads = (int)$request->id_ads;

        $id_watch_log = $request->id_watch_log;
        $advertisement = Advertisement::find($id_ads);
        $date_end = $advertisement->date_end;
        $today = Carbon::now()->format('Y-m-d');
        $watchAdvertisementsLog = new  WatchAdvertisementsLog;
        if ($date_end == $today) {
            $watchAdvertisementsLog = $watchAdvertisementsLog->whereIn('id', $id_watch_log)
                ->whereBetween('created_at', [Carbon::now()->subHour(12), Carbon::now()])->orderBy('created_at', 'ASC')->get();
        } else {
            $watchAdvertisementsLog = $watchAdvertisementsLog->whereIn('id', $id_watch_log)->orderBy('created_at', 'ASC')->get();
        }
        $watchAdvertisementsLog = $watchAdvertisementsLog->groupBy(function ($item) {
            return date('H', strtotime($item->created_at));
        })
            ->map(function ($item) {
                return [
                    'participants' => count($item),
                    'cumulative_mining' => $item->sum('cumulative_mining'),
                ];
            });
        $watchAdvertisementsLog = $watchAdvertisementsLog->toArray();
        $lable = array_keys($watchAdvertisementsLog);
        foreach ($lable as $key => $val) {
            $lable[] = $val . trans('translation.Hour');
            unset($lable[$key]);
        }
        $lable = array_values($lable);
        $value = array_values($watchAdvertisementsLog);
        $participants = [];
        $cumulative_mining = [];
        for ($i = 0; $i < count($value); $i++) {
            $participants[] = $value[$i]['participants'];
            $cumulative_mining[] = $value[$i]['cumulative_mining'];
        }
        $response = [
            'lable' => $lable,
            'participants' =>  $participants,
            'cumulative_mining' =>  $cumulative_mining,
        ];
        return  response()->json($response);
    }
}
