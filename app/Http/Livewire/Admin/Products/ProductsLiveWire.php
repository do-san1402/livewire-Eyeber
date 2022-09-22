<?php

namespace App\Http\Livewire\Admin\Products;

use Livewire\Component;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\EnhancementSetting;
use App\Models\Product;
use App\Models\ProductUpgrade;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class ProductsLiveWire extends Component
{
    public $level_limit_product_upgrade;

    public function __construct() {
        $this->level_limit_product_upgrade = config('apps.common.level_limit_product_upgrade');
    }

    public function create()
    {
        $available_coins = config('apps.common.available_coins');
        $sales_status = config('apps.common.status_sales');
        $product_upgrade_off = config('apps.common.product_upgrade.off');
        $product_upgrade_on = config('apps.common.product_upgrade.on');
        $minings = config('apps.common.mining');
        $glass_category = config('apps.common.glass_category');
        $glass_type = config('apps.common.glass_type');
        $level_limit_product_upgrade = $this->level_limit_product_upgrade;
        return view('admin.products.create', compact('sales_status', 'product_upgrade_off',
        'product_upgrade_on', 'minings','available_coins', 'level_limit_product_upgrade' , 'glass_category','glass_type'));
    }

    public function index()
    {
        $status_sales  = config('apps.common.status_sales');
        return view('admin.products.index',compact('status_sales'));
    }

    public function edit($id)
    {
        $available_coins = config('apps.common.available_coins');
        $product = Product::find($id);
        $glass_category = config('apps.common.glass_category');
        $glass_type = config('apps.common.glass_type');
        $product_upgrade = count($product->product_upgrades) ? $product->product_upgrades[$product->product_upgrades->count() -1] :null;
        $level = $product_upgrade ? $product_upgrade->level : 1;
        foreach($available_coins as $key => $available_coin){
            if( (int) $product->available_coins_id  == $available_coin){
                $product->available_coins_name  = trans('translation.'. $key);
            }
        }
        $glass_category = config('apps.common.glass_category');
        foreach($glass_category as $key => $glass){
            if($product->glass_type === $glass){
                $product->glass_name = trans('translation.'.$key);
                $product->glass_value = config('apps.common.glass_type.'. $key);
                break;
            }
        }
        $level_limit_product_upgrade = $this->level_limit_product_upgrade;
        $sales_status = config('apps.common.status_sales');
        $product_upgrade_off = config('apps.common.product_upgrade.off');
        $product_upgrade_on = config('apps.common.product_upgrade.on');
        $minings = config('apps.common.mining');
        return view('admin.products.edit', compact('product',
         'sales_status', 'product_upgrade_off',
         'product_upgrade_on', 'minings', 'level_limit_product_upgrade', 'product_upgrade', 'glass_category' ,'level', 'glass_category', 'glass_type'));
    }

    public function update(UpdateProductRequest $request, $id)
    {
        try{
            $data = $request->only('name',
            'description' , 'price_matic',
            'repair_cost', 'durability_used',
            'of_mining','mining',
            'sale_status_id',
            'durability'
            );
            $data['glass_type'] = $request->glass;
            if( isset($data['of_mining']) &&  $data['of_mining'] > 0 ){
                $data['durability_used'] =  0;
            }else{
                $data['of_mining'] = 0;
            }
            if ($request->hasFile('image')) {
                $get_image = $request->file('image');
                $new_image          = 'prodcut_' .$id . '.' . $get_image->getClientOriginalExtension();
                $get_image->storeAs('images/products/', $new_image);
            }
            $data['image']   = $new_image ??  Product::where('id', $id)->first()->image ;
            $product = Product::where('id', $id)->update($data);
            $product = Product::find($id);
            if($request->bmt_upgrade_setting){
                $bmt_upgrade_setting = explode(',', $request->bmt_upgrade_setting );  
                $level_array = explode(',', $request->level );
                $bst_upgrade_setting = explode(',', $request->bst_upgrade_setting );
                $durability_upgrade_setting = explode(',', $request->durability_upgrade_setting );
                $mining_upgrade_setting = explode(',', $request->mining_upgrade_setting );
                if(count($product->product_upgrades)){
                    foreach($level_array as $key => $level ){
                        $product_upgrade = new ProductUpgrade();
                        $product_upgrade->product_id = $id;
                        $product_upgrade->bst = $bst_upgrade_setting[$key];
                        $product_upgrade->bmt = $bmt_upgrade_setting[$key];
                        $product_upgrade->durability = $durability_upgrade_setting[$key];
                        $product_upgrade->mining = $mining_upgrade_setting[$key];
                        $product_upgrade->level = $level_array[$key];
                        $product_upgrade->save();
                    }
                }else{
                    foreach($level_array as $key => $level ){
                        $product_upgrade = new ProductUpgrade();
                        $product_upgrade->product_id = $id;
                        $product_upgrade->bst = $bst_upgrade_setting[$key];
                        $product_upgrade->bmt = $bmt_upgrade_setting[$key];
                        $product_upgrade->durability = $durability_upgrade_setting[$key];
                        $product_upgrade->mining = $mining_upgrade_setting[$key];
                        $product_upgrade->level = $level_array[$key];
                        $product_upgrade->save();
                    }
                }
            }
            $data = $request->all();
            if(count($product->enhancement_settings)){
                foreach($data['bst_enhancement'] as $key => $bts_enhancement){
                    if(!$bts_enhancement){
                        break;
                    }
                    if(isset($product->enhancement_settings[$key])){
                        $product->enhancement_settings[$key]->bst = $data['bst_enhancement'][$key];
                        $product->enhancement_settings[$key]->durability = $data['durability_enhancement'][$key];
                        $product->enhancement_settings[$key]->reinforced_division = $data['reinforced_division'][$key];
                        $product->enhancement_settings[$key]->save();
                    }else{
                        $enhancement_setting = new EnhancementSetting();
                        $enhancement_setting->bst = $data['bst_enhancement'][$key];
                        $enhancement_setting->product_id = $id;
                        $enhancement_setting->durability = $data['durability_enhancement'][$key];
                        $enhancement_setting->mining = $data['mining_volume_enhancement'][$key];
                        $enhancement_setting->reinforced_division =  $data['reinforced_division'][$key];
                        $enhancement_setting->save();
                    }
                }
            }else{
                foreach($data['bst_enhancement'] as $key => $bts_enhancement){
                    if(!$bts_enhancement){
                        break;
                    }
                    $enhancement_setting = new EnhancementSetting();
                    $enhancement_setting->bst = $data['bst_enhancement'][$key];
                    $enhancement_setting->product_id = $product->id;
                    $enhancement_setting->durability = $data['durability_enhancement'][$key];
                    $enhancement_setting->mining = $data['mining_volume_enhancement'][$key];
                    $enhancement_setting->reinforced_division =  $data['reinforced_division'][$key];
                    $enhancement_setting->save();
    
                }
            }
            return redirect()->back()->with('success', trans('translation.Your_work_has_been_saved'));
        }catch(Exception $e){
            Log::error($e->getMessage());
            return redirect()->back()->with('error', trans('translation.Something_went_wrong'));
        }
    }

    public function store(StoreProductRequest $request)
    {
        try{  
            $product = new Product();
            $product->glass_type = $request->glass;
            $product->name = $request->name;
            $product->description = $request->description;
            $product->price_matic = $request->price_matic;
            $product->mining = $request->mining;
            $product->level = 1;// default
            if(isset($request->durability_used) && $request->durability_used > 0){
                $product->durability_used = $request->durability_used;
                $product->repair_cost =  config('apps.common.repair_cost.Direct_setting');
                $product->of_mining = 0;
            }else{
                $product->of_mining = $request->of_mining;
                $product->repair_cost =  config('apps.common.repair_cost.Auto_setup');
                $product->durability_used = 0;
            }
            $product->sale_status_id = config('apps.common.status_sales.Sale');
            $new_image = "";
            if ($request->hasFile('image')) {
                $get_image = $request->file('image');
                $new_image          = 'prodcut_' . time() . '.' . $get_image->getClientOriginalExtension();
                $get_image->storeAs('images/products/', $new_image);    
            }
            $product->image =  $new_image;
            $product->available_coins_id = $request->available_coin_id;
            $product->durability = $request->durability;
            $product->decrease =  $request->decrease;
            $product->mining_amount_when_decreasing =  $request->mining_amount_when__decrease;
            $product->save();
            if($request->level){
                $bmt_upgrade_setting = explode(',', $request->bmt_upgrade_setting );  
                $level_array = explode(',', $request->level );
                $bst_upgrade_setting = explode(',', $request->bst_upgrade_setting );
                $durability_upgrade_setting = explode(',', $request->durability_upgrade_setting );
                $mining_upgrade_setting = explode(',', $request->mining_upgrade_setting );
                foreach($level_array as $key => $level ){
                    $product_upgrade = new ProductUpgrade();
                    $product_upgrade->product_id = $product->id;
                    $product_upgrade->bst = $bst_upgrade_setting[$key];
                    $product_upgrade->bmt = $bmt_upgrade_setting[$key];
                    $product_upgrade->durability = $durability_upgrade_setting[$key];
                    $product_upgrade->mining = $mining_upgrade_setting[$key];
                    $product_upgrade->level = $level_array[$key];
                    $product_upgrade->save();
                }
            }
            $data = $request->all();
            foreach($data['bst_enhancement'] as $key => $bts_enhancement){
                if(!$bts_enhancement){
                    break;
                }
                $enhancement_setting = new EnhancementSetting();
                $enhancement_setting->bst = $data['bst_enhancement'][$key];
                $enhancement_setting->product_id = $product->id;
                $enhancement_setting->durability = $data['durability_enhancement'][$key];
                $enhancement_setting->mining = $data['mining_volume_enhancement'][$key];
                $enhancement_setting->reinforced_division =  $data['reinforced_division'][$key];
                $enhancement_setting->save();
            }
            return redirect()->route('admin.products.index')->with('success', trans('translation.Your_work_has_been_saved'));
        }catch(Exception $e){
            Log::error($e->getMessage());
            return redirect()->back()->with('error', trans('translation.Something_went_wrong'));
        } 
    }

    public function fetchData(Request $request)
    {
        $products = Product::query();
        return Datatables::of($products)
            ->filter(function ($instance) use ($request) {
                $data = $request->all();
                if (isset($data["status_products"]) &&  count($data["status_products"])) {
                    $instance->whereIn('sale_status_id', $data["status_products"]);
                }

                if (!empty($request->get('search'))) {
                    $instance->where(function ($w) use ($request) {
                        $search = $request->get('search');
                        $w->Where('name', 'LIKE', "%$search%");
                        $sales_status = config('apps.common.status_sales');
                        $status = '';
                        foreach($sales_status as $key =>  $sale_status){
                            if(strtolower($search) == strtolower(str_replace('_', ' ', $key)) || strtolower($search) == strtolower(trans('translation.'.$key)) ){
                                    $status = $sale_status;
                            }
                        }
                        if($status !== ''){
                            $w->orWhere('sale_status_id',$status);
                        }    
                    });
                }
                $instance->get();
            })->addColumn('sale_status_id', function (Product $product) {
                $status_sales = config('apps.common.status_sales');
                foreach ($status_sales as $key=>$status_sale){
                    if($product->sale_status_id === $status_sale){
                    return trans("translation.$key");
                    }
                }
            })->editColumn('name', function (Product $product) {
                return $product->name_glass;
            })->editColumn('price_matic', function (Product $product) {
                return number_format($product->price_matic, 2, ',', ' ' ) .' '. trans('translation.MATIC');
            })->editColumn('price_krw', function (Product $product) {
                return number_format($product->price_krw, 2, ',', ' '  ).' '. trans('translation.원');
            })->editColumn('price_usd', function (Product $product) {
                return number_format($product->price_usd, 2, ',', ' ').' '. trans('translation.$');

            })->addColumn('checkbox', function ($item) {
                return '<input role="button" type="checkbox" class="single_checkbox" value="' . $item->id . '" name="product_id[]" />';
            })->addColumn('action', function ($item) {
                return '<a href="' . route('admin.products.edit', $item->id) . '" class="btn btn-outline-secondary btn-sm edit">
                            <i class="fas fa-pencil-alt"></i>
                        </a>';
            })->make(true);
    }
    public function changeStatus(Request $request)
    {
        try {
            $response = [
                'status' =>  config('apps.common.status.success'),
                'message' =>  trans('translation.Success')
            ];
            $data = $request->all();
            if (isset($data['products']) && count($data['products'])) {
                Product::whereIn('id', $data['products'])->update(['sale_status_id' => $data['status']]);
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

    public function delete(Request $request)
    {
        try {
            $response = [
                'status' => config('apps.common.status.success'),
                'message' => trans('translation.Success'),
            ];
            $data = $request->all();
            if (isset($data['products']) && count($data['products'])) {
                Product::whereIn('id', $data['products'])->delete();
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
}
