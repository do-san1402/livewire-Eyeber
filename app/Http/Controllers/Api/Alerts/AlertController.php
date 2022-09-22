<?php

namespace App\Http\Controllers\Api\Alerts;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resource\AlertCollection;
use App\Models\Alert;

class AlertController extends BaseController
{
    public function index()
    {
        $alerts =  Alert::where('status', config('apps.common.ads_status.show'))
        ->where('date_start', '<=', date('Y-m-d'))
        ->where('date_end', '>=', date('Y-m-d'))->get();
        return $this->sendResponse(new AlertCollection($alerts), 'List alerts sucess');
    }
}