<?php

namespace App\Http\Controllers\Api\Banners;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resource\BannerCollection;
use App\Models\Banner;

class BannerController extends BaseController
{
    public function index()
    {
        $banners =  Banner::where('status', config('apps.common.ads_status.show'))
        ->where('date_start', '<=', date('Y-m-d'))
        ->where('date_end', '>=', date('Y-m-d'))->get();
        return $this->sendResponse(new  BannerCollection($banners), 'List Banners sucess');
    }
}