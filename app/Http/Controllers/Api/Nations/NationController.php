<?php

namespace App\Http\Controllers\Api\Nations;

use App\Http\Controllers\Api\BaseController;
use App\Models\Nation;

class NationController extends BaseController
{
    public function list()
    {
        $nation = Nation::all();
        return $this->sendResponse($nation, 'Nation List success');
    }
}