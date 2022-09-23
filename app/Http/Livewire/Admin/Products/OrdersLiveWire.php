<?php

namespace App\Http\Livewire\Admin\Products;

use Livewire\Component;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Carbon;


class OrdersLiveWire extends Component
{
    public function index(Request $request)
    {
        $product_id = $request->product_id ? $request->product_id : -1 ;
        $user_id = $request->user_id ? $request->user_id : null;
        $order_categorys = config('apps.common.category_order');
        $products = Product::all();
        $status_orders = config('apps.common.status_order');
        return view('livewire.admin.products.purchase_status', compact('order_categorys', 'products', 'status_orders', 'product_id' , 'user_id'));
    }

    public function fetchData(Request $request)
    {
        $orders = Order::query();
        return Datatables::of($orders)
            ->filter(function ($instance) use ($request) {
                $data = $request->all();

                if (isset($data["category_id"]) && (int) $data["category_id"] > -1) {
                    $instance->where('category_id', $data["category_id"]);
                }
                if (isset($data["product_id"]) && (int) $data["product_id"] > -1) {
                    $instance->whereHas('order_details', function ($q) use ($data) {
                        $q->whereHas('product', function ($q) use ($data) {
                            $q->where('product_id', $data["product_id"]);
                        });
                    });
                }
                if($data["user_id"]){
                    $instance->where('user_id', $data["user_id"]);
                }
                if (isset($data["list_status"]) && count($data["list_status"])) {
                    $instance->whereIn('status_id', $data["list_status"]);
                }
                if (!empty($request->get('search'))) {
                    $search = $request->get('search');
                    $instance->whereHas('user', function ($q) use ($search) {
                        $q->where('nick_name', 'like', "%$search%");
                    });
                }
                $instance->get();
            })->addColumn('user_name', function (Order $order) {
                if($order->user){
                    return $order->user->nick_name;
                }
                return '';
            })->editColumn('category_name', function (Order $order) {
                $category_orders = config('apps.common.category_order');
                foreach ($category_orders as $key => $category_order) {
                    if ($order->category_id == $category_order) {
                        return   trans('translation.' . $key);
                    }
                };
            })->addColumn('product_name', function (Order $order) {
                if($order->order_details){
                    return $order->order_details->product->name;
                }
                return '';
            })->addColumn('status_order', function (Order $order) {
                $list_status_order = config('apps.common.status_order');
                foreach ($list_status_order as $key => $status_order) {
                    if ((int) $status_order == $order->status_id) {
                        return   trans('translation.' . $key);
                    }
                }
            })
            ->addColumn('method_of_payment', function (Order $order) {
                $available_coins = config('apps.common.available_coins');
                foreach ($available_coins as $key => $available_coin) {
                    if ((int)$order->method_of_payment == $available_coin) {
                        return trans('translation.' . $key);
                    }
                }
            })->addColumn('amount_of_payment', function (Order $order) {
                $unit_money = config('apps.common.unit_money');
                foreach ($unit_money as $key => $money) {
                    if ((int)$order->method_of_payment === $money) {
                        return number_format($order->amount_of_payment) . trans('translation.' . $key);
                    }
                }
            })->addColumn('cancellation', function (Order $order) {
                $cancellation = config('apps.common.cancellation');
                if ($order->cancellation_processing == $cancellation) {
                    return '<a type="button" class="btn btn-danger waves-effect waves-light">' . trans('translation.cancellation') . '</a>';
                }
            })->addColumn('checkbox', function ($item) {
                return '<input type="checkbox" class="single_checkbox" value="' . $item->id . '" name="order_id[]" />';
            })->rawColumns(['cancellation'])
            ->make(true);
    }

    public function status_sales(Request $request)
    {
        return view('livewire.admin.products.sales_status');
    }

    public function status_sales_fetchData(Request $request)
    {
        $orders =  new Order();
        $data = $request->all();
        $orders = $orders ->withSum('order_details', 'money_bmt')
        ->withSum('order_details', 'money_bst')
        ->withSum('order_details', 'money_matic');
       
        if ($request->from_date != '' && $request->to_date != '') {
            $orders = $orders
            ->whereBetween('product_purchase_date', array($request->from_date, $request->to_date))
            ->orderBy('product_purchase_date', 'DESC')
            ->get()->groupBy('product_purchase_date');
        }else{
            $date = isset($data["date"]['date']) ? (int) $data["date"]['date'] : 7;
            if ($date > 30) {
                $dateS = Carbon::now()->startOfMonth()->subMonth(5);
                $dateE = Carbon::now();
                $orders = $orders->whereYear('product_purchase_date',  '=', Carbon::now()->year)
                    ->whereBetween('product_purchase_date', [$dateS, $dateE])
                    ->selectRaw('MONTH(product_purchase_date) as date')
                    ->orderBy('product_purchase_date', 'DESC')
                    ->orderBy('date', 'DESC')->get()->groupBy('date');
                $orders = $orders->map(function ($money) {
                    return [
                        'date' => date_format(date_create($money[0]->product_purchase_date),'Y-m'),
                        'sum_money_bmt' => $money->sum('order_details_sum_money_bmt') ,
                        'sum_money_bst' => $money->sum('order_details_sum_money_bst'),
                        'sum_money_matic' => $money->sum('order_details_sum_money_matic'),
                    ];
                });

                return Datatables::of($orders)->make(true);
            } else {
                $dateE = Carbon::today()->subDays ($date)->format('Y-m-d');
                $orders = $orders->whereBetween('product_purchase_date', [$dateE, Carbon::now()])
                ->orderBy('product_purchase_date', 'DESC')->get()->groupBy('product_purchase_date');   
            }
        }

        $orders = $orders->map(function ($money) {
            return [
                'date' => $money[0]->product_purchase_date,
                'sum_money_bmt' => $money->sum('order_details_sum_money_bmt') ,
                'sum_money_bst' => $money->sum('order_details_sum_money_bst'),
                'sum_money_matic' => $money->sum('order_details_sum_money_matic'),
            ];
        });

        return Datatables::of($orders)->make(true);
    }



    public function revenue_detail(Request $request)
    {
        $data = $request->all();
        $response = [];
        $orders = Order::withSum('order_details', 'money_bmt')
        ->withSum('order_details', 'money_bst')
        ->withSum('order_details', 'money_matic');
        
        $date = $data['date'];
        $checkDate = explode('-',$date);
        if(count($checkDate) === 2){
            $orders = $orders->where('product_purchase_date','like', "%".$date.'%')->get()->groupBy('category_id');
        }else{
            $orders = $orders->where('product_purchase_date', $date)->get()->groupBy('category_id');
        }
        $matic = (float)explode(' ',$data['matic'])[0];
        $bmt = (float)explode(' ',$data['bmt'])[0];
        $bst = (float)explode(' ',$data['bst'])[0];
        $orders = $orders->map(function ($money)use($matic, $bmt, $bst) {
            return [
                'category_id' => $money[0]->category_id,
                'percent_bmt' => number_format(($money->sum('order_details_sum_money_bmt') / $bmt) * 100, 2),
                'percent_bst' => number_format(($money->sum('order_details_sum_money_bst') / $bst) * 100, 2),
                'percent_matic' => number_format(($money->sum('order_details_sum_money_matic') / $matic) * 100,2),
                'sum_money_bmt' => $money->sum('order_details_sum_money_bmt') ,
                'sum_money_bst' => $money->sum('order_details_sum_money_bst'),
                'sum_money_matic' => $money->sum('order_details_sum_money_matic'),
            ];
        });
        $cateogory_order = config('apps.common.category_order');
        foreach($cateogory_order as $key => $category){
            $check = $orders->filter(function ($value, $key) use($category) {
                return (int)$value['category_id'] === (int)$category;
            });
            if(count($check)){
                $response[$key] =  $check->first();
            }
        }
        $response = [
            'matic' => $data['matic'],
            'bst' => $data['bst'],
            'bmt' => $data['bmt'],
           'response' =>  $response
        ];
        return  response()->json($response);
       
    }
}
