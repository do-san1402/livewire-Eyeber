<?php

namespace App\Http\Controllers\Api\Products;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resource\PaginateResource;
use App\Http\Resource\ProductResource;
use App\Models\Product;
use App\Models\SendProductLog;
use App\Models\User;
use App\Services\Orders\OrderService;
use App\Services\ProductInventorys\ProductInventoryService;
use App\Services\Wallets\WalletService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class ProductController extends BaseController
{
    const paginate_size = 4;
    public function index(Request $request)
    {
        $paginate_size =  $request->paginate_size ?? self::paginate_size;
        $products = Product::query()->where('sale_status_id',config('apps.common.status_sales.Sale'))->paginate($paginate_size);

        return  $this->sendResponse(new PaginateResource($products), 'Product list success');
    }

    public function list_shop(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'repair' => 'nullable|boolean',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $paginate_size =  $request->paginate_size ?? self::paginate_size;
        $request = $request->all();
        $products = new Product();
        $products = $products->where('sale_status_id',config('apps.common.status_sales.Sale'));

        if (isset($request['repair'])) {
            if ($request['repair']) {
                $products =  $products->with(['product_inventory' => function ($query) {
                    $user = Auth::user();
                    $query->where('user_id', $user->id);
                }])->where('durability', '<', 100);
            } else {
                $products =  $products->with(['product_inventory' => function ($query) {
                    $user = Auth::user();
                    $query->where('user_id', $user->id);
                }])->where('durability', 100);
            }
        } else {
            $products =  $products->with(['product_inventory' => function ($query) {
                $user = Auth::user();
                $query->where('user_id', $user->id);
            }]);
        }
        $products = $products->paginate($paginate_size);

        return $this->sendResponse(new PaginateResource($products), 'Product Inventory list success');
    }

    public function product_detail($id)
    {
        $product = Product::find($id);
        return $this->sendResponse(new ProductResource($product), 'Product detail success');
    }

    

}