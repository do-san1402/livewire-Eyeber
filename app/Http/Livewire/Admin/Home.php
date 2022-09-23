<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Advertisement;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\User;
use App\Models\WatchAdvertisementsLog;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class Home extends Component
{
     /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        return view('index');
    }

    /*Language Translation*/
    public function changeLanguage($locale)
    {
        if ($locale) {
            App::setLocale($locale);
            Session::put('lang', $locale);
            Session::save();
            return redirect()->back()->with('locale', $locale);
        } else {
            return redirect()->back();
        }
    }

    public function fetchData(Request $request)
    {

        $date = isset($request->date) ? (int) $request->date : 1;
        $today = Carbon::now()->format('Y-m-d');
        $watchAdvertisementsLog = new  WatchAdvertisementsLog();
        $user = new  User();
        $order_detail = new OrderDetail();
        if ($date == 1) {
            $newUser = $user->whereDate('created_at', '=', $today);
            $totalMatic = $order_detail->whereDate('created_at', '=', $today)->sum('money_matic');
            $watchAdvertisementsLog = $watchAdvertisementsLog
                ->whereDate('created_at', '=', $today)
                ->whereBetween('created_at', [Carbon::now()->subHour(12), Carbon::now()])->orderBy('created_at', 'ASC')
                ->get();

            $totalTime = 0;
            $totalCumulativeMining = 0;
            foreach ($watchAdvertisementsLog as $value) {
                $totalTime += $value->time;
                $totalCumulativeMining += $value->cumulative_mining;
            }
            $totalTime =  number_format($totalTime / 60, 2, ',', ' ');

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
        } else {
            $user = $user->whereDate('created_at', '<', Carbon::now()->subDays($date));
            $newUser = User::whereBetween('created_at', [Carbon::now()->subDays($date), Carbon::now()]);
            $totalMatic = $order_detail->whereBetween('created_at', [Carbon::now()->subDays($date), Carbon::now()])->sum('money_matic');
            $watchAdvertisementsLog = $watchAdvertisementsLog
                ->whereBetween('created_at', [Carbon::now()->subDays($date), Carbon::now()])
                ->orderBy('created_at', 'ASC')->get();

            $totalTime = 0;
            $totalCumulativeMining = 0;
            foreach ($watchAdvertisementsLog as $value) {
                $totalTime += $value->time;
                $totalCumulativeMining += $value->cumulative_mining;
            }
            $totalTime =  number_format($totalTime / 60, 2, ',', ' ');

            $watchAdvertisementsLog = $watchAdvertisementsLog->groupBy(function ($item) {
                return date('Y-m-d', strtotime($item->created_at));
            })->map(function ($item) {
                return [
                    'participants' => count($item),
                    'cumulative_mining' => $item->sum('cumulative_mining'),
                    'times' => $item->sum('time'),
                ];
            });
            $watchAdvertisementsLog = $watchAdvertisementsLog->toArray();
            $lable = array_keys($watchAdvertisementsLog);
        }

        $userConnect = count($user->get());
        $totalNewUser = count($newUser->get());

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
            'totalTime' => $totalTime,
            'totalCumulativeMining' => number_format($totalCumulativeMining, 1, ',', ' '),
            'unitCumulativeMining' => 'BST',
            'userConnect' => $userConnect,
            'totalNewUser' => $totalNewUser,
            'totalMatic' => number_format($totalMatic, 1, ',', ' '),
            'unitTotalMatic' => 'MATIC',
        ];
        return  response()->json($response);
    }


    public function rankingMonitor(Request $request)
    {

        $date = isset($request['date']['date']) ? (int) $request['date']['date'] : 1;
        $data = new  WatchAdvertisementsLog();
        if ($date == 1) {
            $data = $data->with('advertisement')
                ->whereBetween('created_at', [Carbon::now()->startOfDay(), Carbon::now()])->get();
        } else {
            $data = $data->with('advertisement')
                ->whereBetween('created_at', [Carbon::now()->subDays($date), Carbon::now()])->get();
        }
        $data = $data->groupBy(function ($item) {
            return  $item['advertisement_id'];
        })
            ->map(function ($q) {
                return [
                    'item' => $q,
                    'advertisement_id' => $q[0]['advertisement_id'],
                    'cumulative_mining' => $q->sum('cumulative_mining'),
                ];
            })->sortByDesc('cumulative_mining')->take(5);
        return DataTables::of($data)
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

    public function rankingOrder(Request $request)
    {
        $date = isset($request['date']['date']) ? (int) $request['date']['date'] : 1;
        $order_detail = new  OrderDetail();
        if ($date == 1) {
            $order_detail = $order_detail->whereBetween('created_at', [Carbon::now()->startOfDay(), Carbon::now()]);
        } else {
            $order_detail = $order_detail->whereBetween('created_at', [Carbon::now()->subDays($date), Carbon::now()]);
        }
        $order_detail = $order_detail ->where('money_matic', '>', 0)->get()
        ->groupBy('order_id')->map(function ($q) {
            return [
                'item' => $q,
                'money_matic' => $q->sum('money_matic'),
                'product_id' => $q[0]['product_id'],
            ];
        })->sortByDesc('money_matic')->take(5);
        return Datatables::of($order_detail)
            ->addIndexColumn()
            ->addColumn('sales_volume', function ($data) {
                return count($data['item']);
            })
            ->addColumn('name', function ($data) {
                $product = Product::find($data['product_id']);
                if ($product) {
                    return  $product->name;
                }
            })
        ->make(true);
    }
}
